<?php
// Ce fichier gere les utilisateurs et les categories de l'espace administrateur.

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Database;
use App\Models\JobHuntData;

class AdminController extends Controller
{
    // Cette methode affiche les indicateurs principaux de l'administration.
    public function dashboard(): void
    {
        $this->render('admin.dashboard', [
            'metrics' => JobHuntData::adminMetrics(),
            'users' => \array_slice(JobHuntData::allUsers(), 0, 5),
            'jobs' => JobHuntData::jobs(),
            'messages' => JobHuntData::contactMessages(),
        ]);
    }

    // Cette methode affiche la liste des utilisateurs.
    public function users(): void
    {
        $this->render('admin.users', ['users' => JobHuntData::allUsers()]);
    }

    // Cette methode affiche les categories et les competences existantes.
    public function categories(): void
    {
        $this->render('admin.categories', [
            'categories' => JobHuntData::categoriesList(),
            'skills' => JobHuntData::skills(),
        ]);
    }

    // Cette methode active ou suspend un compte utilisateur.
    public function updateUserStatus(): void
    {
        $status = $_POST['status'] ?? '';
        if (!\in_array($status, ['active', 'suspended'], true)) {
            $this->flash('Choose a valid user status.', 'error');
            $this->redirect('admin-users');
        }

        Database::connection()->prepare('UPDATE users SET status = ? WHERE id = ? AND id != ?')
            ->execute([$status, $_POST['user_id'] ?? 0, $this->userId()]);
        $this->flash('User status updated.');
        $this->redirect('admin-users');
    }

    // Cette methode ajoute une categorie d'offres si son nom est renseigne.
    public function createCategory(): void
    {
        $name = trim($_POST['name'] ?? '');
        if ($name === '') {
            $this->flash('Enter a category name.', 'error');
            $this->redirect('admin-categories');
        }

        Database::connection()->prepare('INSERT IGNORE INTO job_categories (name, description) VALUES (?, ?)')
            ->execute([$name, trim($_POST['description'] ?? '')]);
        $this->flash('Category saved.');
        $this->redirect('admin-categories');
    }
}
