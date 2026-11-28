<?php
// Ce fichier gere la connexion, la creation de compte et les sessions utilisateurs.

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Database;
use PDOException;

class AuthController extends Controller
{
    // Cette methode deconnecte un compte qui a ete suspendu.
    public function checkAccount(): void
    {
        if (empty($_SESSION['user']['id'])) {
            return;
        }

        $query = Database::connection()->prepare('SELECT status FROM users WHERE id = ?');
        $query->execute([$this->userId()]);

        if ($query->fetchColumn() !== 'active') {
            unset($_SESSION['user']);
            session_regenerate_id(true);
        }
    }

    // Cette methode verifie le mot de passe puis ouvre la session.
    public function signIn(): void
    {
        // On cherche le compte avec son adresse courriel.
        $query = Database::connection()->prepare(
            'SELECT u.id, u.full_name, u.email, u.password_hash, u.status, r.name AS role
             FROM users u JOIN roles r ON r.id = u.role_id WHERE u.email = ?'
        );
        $query->execute([strtolower(trim($_POST['email'] ?? ''))]);
        $user = $query->fetch();

        // On accepte uniquement un compte actif avec le bon mot de passe.
        if (!$user || $user['status'] !== 'active' || !password_verify($_POST['password'] ?? '', $user['password_hash'])) {
            $this->flash('Email or password is incorrect.', 'error');
            $this->redirect('signin');
        }

        // On garde les informations utiles dans la session pour les prochaines pages.
        session_regenerate_id(true);
        $_SESSION['user'] = [
            'id' => (int) $user['id'],
            'name' => $user['full_name'],
            'email' => $user['email'],
            'role' => $user['role'],
        ];
        $this->redirect($user['role'] . '-dashboard');
    }

    // Cette methode cree un compte et son profil associe.
    public function register(string $role): void
    {
        // Les formulaires candidat et entreprise utilisent des champs de nom differents.
        $name = trim($_POST['full_name'] ?? $_POST['company_name'] ?? '');
        $email = strtolower(trim($_POST['email'] ?? ''));
        $password = $_POST['password'] ?? '';

        if (
            $name === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)
            || \strlen($password) < 10 || $password !== ($_POST['password_confirmation'] ?? '')
            || empty($_POST['accept_terms'])
        ) {
            $this->flash('Check your details, passwords, and agreement to the terms.', 'error');
            $this->redirect('register-' . $role);
        }

        // On retrouve l'identifiant du role a partir de son nom.
        $db = Database::connection();
        $query = $db->prepare('SELECT id FROM roles WHERE name = ?');
        $query->execute([$role]);
        $roleId = $query->fetchColumn();

        // On cree le compte et son profil ensemble, pour eviter un compte incomplet.
        try {
            $db->beginTransaction();
            // Le mot de passe est transforme avant d'etre enregistre.
            $query = $db->prepare(
                "INSERT INTO users (role_id, full_name, email, password_hash, status)
                VALUES (?, ?, ?, ?, 'active')"
            );
            $query->execute([$roleId, $name, $email, password_hash($password, PASSWORD_DEFAULT)]);
            $userId = (int) $db->lastInsertId();

            // Chaque type de compte a ses propres informations de profil.
            if ($role === 'candidate') {
                $db->prepare('INSERT INTO candidate_profiles (user_id) VALUES (?)')->execute([$userId]);
                $db->prepare('INSERT INTO user_profiles (user_id) VALUES (?)')->execute([$userId]);
            } else {
                $query = $db->prepare(
                    "INSERT INTO company_profiles (user_id, company_name, industry, location, website, verification_status)
                    VALUES (?, ?, ?, ?, ?, 'pending')"
                );
                $query->execute([
                    $userId,
                    $name,
                    $_POST['industry'] ?? '',
                    $_POST['location'] ?? '',
                    $_POST['website'] ?? '',
                ]);
                $companyId = (int) $db->lastInsertId();
                $db->prepare('INSERT INTO company_members (company_id, user_id, role, is_owner) VALUES (?, ?, ?, 1)')
                    ->execute([$companyId, $userId, 'owner']);
                $db->prepare('INSERT INTO user_profiles (user_id) VALUES (?)')->execute([$userId]);
            }
            $db->commit();
        } catch (PDOException $error) {
            // Une adresse courriel deja utilisee est signalee simplement au formulaire.
            $db->rollBack();
            if ($error->getCode() === '23000') {
                $this->flash('An account already uses this email.', 'error');
                $this->redirect('register-' . $role);
            }
            throw $error;
        }

        $this->flash('Account created. You can now sign in.');
        $this->redirect('signin');
    }
}
