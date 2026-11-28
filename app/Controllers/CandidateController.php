<?php
// Ce fichier gere les pages et les actions reservees aux candidats.

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Database;
use App\Models\JobHuntData;
use PDOException;

class CandidateController extends Controller
{
    // Cette methode affiche les offres accessibles aux candidats.
    public function jobs(): void
    {
        $this->render('candidate.jobs', ['jobs' => JobHuntData::jobs($_GET)]);
    }

    // Cette methode affiche les offres enregistrees par le candidat.
    public function savedJobs(): void
    {
        $this->render('candidate.saved-jobs', ['jobs' => JobHuntData::savedJobs($this->userId())]);
    }

    // Cette methode affiche les candidatures envoyees par le candidat.
    public function applications(): void
    {
        $this->render('candidate.applications', [
            'applications' => JobHuntData::candidateApplications($this->userId()),
        ]);
    }

    // Cette methode affiche le profil du candidat.
    public function profile(): void
    {
        $this->render('candidate.profile', ['profile' => JobHuntData::candidateProfile($this->userId())]);
    }

    // Cette methode affiche les CV du candidat.
    public function resumes(): void
    {
        $this->render('candidate.resumes', ['resumes' => JobHuntData::candidateResumes($this->userId())]);
    }

    // Cette methode prepare les donnees du tableau de bord candidat.
    public function dashboard(): void
    {
        $id = $this->userId();
        $this->render('candidate.dashboard', [
            'metrics' => JobHuntData::candidateMetrics($id),
            'applications' => JobHuntData::candidateApplications($id),
            'notifications' => [],
        ]);
    }

    // Cette methode verifie le CV et ajoute la candidature a la base.
    public function apply(): void
    {
        // Seul un candidat connecte peut envoyer une candidature.
        if (($_SESSION['user']['role'] ?? '') !== 'candidate') {
            $this->flash('Sign in as a candidate to apply.', 'error');
            $this->redirect('signin');
        }

        $db = Database::connection();
        $resumeId = $_POST['resume_id'] ?? null;

        // Le CV choisi doit appartenir au candidat connecte.
        if ($resumeId) {
            $query = $db->prepare('SELECT id FROM resumes WHERE id = ? AND user_id = ?');
            $query->execute([$resumeId, $this->userId()]);
            if (!$query->fetchColumn()) {
                $this->flash('Choose one of your resumes.', 'error');
                $this->redirect('jobs');
            }
        }

        // La base refuse une deuxieme candidature pour la meme offre.
        try {
            $query = $db->prepare(
                "INSERT INTO applications (user_id, job_id, resume_id, cover_letter)
                 SELECT ?, id, ?, ? FROM job_offers WHERE id = ? AND status = 'active'"
            );
            $query->execute([$this->userId(), $resumeId, $_POST['cover_letter'] ?? '', $_POST['job_id']]);
        } catch (PDOException $error) {
            if ($error->getCode() === '23000') {
                $this->flash('You already applied for this job.', 'error');
                $this->redirect('job-details', ['id' => $_POST['job_id']]);
            }
            throw $error;
        }

        $sent = $query->rowCount() > 0;
        $this->flash($sent ? 'Application sent.' : 'This job is no longer available.', $sent ? 'success' : 'error');
        $this->redirect('candidate-applications');
    }

    // Cette methode enregistre une offre dans les favoris du candidat.
    public function saveJob(): void
    {
        if (($_SESSION['user']['role'] ?? '') !== 'candidate') {
            $this->flash('Sign in as a candidate to save jobs.', 'error');
            $this->redirect('signin');
        }

        Database::connection()->prepare('INSERT IGNORE INTO saved_jobs (user_id, job_id) VALUES (?, ?)')
            ->execute([$this->userId(), $_POST['job_id'] ?? 0]);
        $this->flash('Job saved.');
        $this->redirect('job-details', ['id' => $_POST['job_id'] ?? 0]);
    }

    // Cette methode met a jour le profil et le nom de session du candidat.
    public function saveProfile(): void
    {
        $db = Database::connection();
        $userId = $this->userId();
        $name = $_POST['full_name'] ?? '';

        $db->prepare('UPDATE users SET full_name = ? WHERE id = ?')->execute([$name, $userId]);
        // Les deux profils sont crees pendant l'inscription, on peut les modifier directement.
        $db->prepare(
            'UPDATE candidate_profiles SET headline = ?, professional_summary = ? WHERE user_id = ?'
        )->execute([$_POST['headline'] ?? '', $_POST['professional_summary'] ?? '', $userId]);
        $db->prepare(
            'UPDATE user_profiles SET phone = ?, location = ? WHERE user_id = ?'
        )->execute([$_POST['phone'] ?? '', $_POST['location'] ?? '', $userId]);

        $_SESSION['user']['name'] = $name;
        $this->flash('Profile saved.');
        $this->redirect('candidate-profile');
    }

    // Cette methode verifie le type du fichier avant de sauvegarder le CV en prive.
    public function uploadResume(): void
    {
        // La taille et le type empechent d'enregistrer un fichier qui n'est pas un CV accepte.
        $file = $_FILES['resume'] ?? null;
        if (!$file || $file['error'] !== UPLOAD_ERR_OK || $file['size'] > 5 * 1024 * 1024) {
            $this->flash('Choose a resume file smaller than 5 MB.', 'error');
            $this->redirect('candidate-resumes');
        }

        $types = [
            'application/pdf' => 'pdf',
            'application/msword' => 'doc',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'docx',
        ];
        $type = (new \finfo(FILEINFO_MIME_TYPE))->file($file['tmp_name']);
        if (!isset($types[$type])) {
            $this->flash('Only PDF, DOC, or DOCX files are accepted.', 'error');
            $this->redirect('candidate-resumes');
        }

        // Les CV restent hors du dossier public du site.
        $folder = dirname(__DIR__, 2) . '/storage/private/resumes';
        if (!is_dir($folder)) {
            mkdir($folder, 0750, true);
        }
        $filename = bin2hex(random_bytes(16)) . '.' . $types[$type];
        if (!move_uploaded_file($file['tmp_name'], $folder . '/' . $filename)) {
            $this->flash('The resume could not be uploaded. Try again.', 'error');
            $this->redirect('candidate-resumes');
        }

        Database::connection()->prepare(
            'INSERT INTO resumes (user_id, file_name, file_path, file_type, is_primary) VALUES (?, ?, ?, ?, 0)'
        )->execute([$this->userId(), basename($file['name']), $filename, $type]);
        $this->flash('Resume uploaded.');
        $this->redirect('candidate-resumes');
    }

    // Cette methode telecharge un CV appartenant au candidat connecte.
    public function downloadResume(): void
    {
        // On cherche le fichier avec l'identifiant du candidat pour proteger les CV personnels.
        $query = Database::connection()->prepare(
            'SELECT file_name, file_path, file_type FROM resumes WHERE id = ? AND user_id = ?'
        );
        $query->execute([$_GET['id'] ?? 0, $this->userId()]);
        $resume = $query->fetch();
        $file = dirname(__DIR__, 2) . '/storage/private/resumes/' . ($resume['file_path'] ?? '');

        if (!$resume || !is_file($file)) {
            http_response_code(404);
            exit('Resume not found.');
        }
        header('Content-Type: ' . $resume['file_type']);
        header('Content-Disposition: attachment; filename="' . basename($resume['file_name']) . '"');
        readfile($file);
        exit;
    }

    // Cette methode retire une offre des favoris du candidat.
    public function removeSavedJob(): void
    {
        Database::connection()->prepare('DELETE FROM saved_jobs WHERE user_id = ? AND job_id = ?')
            ->execute([$this->userId(), $_POST['job_id'] ?? 0]);
        $this->flash('Saved job removed.');
        $this->redirect('candidate-saved');
    }
}
