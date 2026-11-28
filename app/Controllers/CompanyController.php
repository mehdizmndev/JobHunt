<?php
// Ce fichier gere les offres, le profil et les candidatures des entreprises.

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Database;
use App\Models\JobHuntData;

class CompanyController extends Controller
{
    // Cette methode affiche les offres de l'entreprise connectee.
    public function jobs(): void
    {
        $this->render('company.jobs', ['jobs' => JobHuntData::companyJobs($this->userId())]);
    }

    // Cette methode affiche le profil de l'entreprise.
    public function profile(): void
    {
        $this->render('company.profile', ['profile' => JobHuntData::companyProfile($this->userId())]);
    }

    // Cette methode affiche les candidats ayant postule aux offres de l'entreprise.
    public function candidates(): void
    {
        $this->render('company.candidates', [
            'candidates' => JobHuntData::companyCandidates($this->userId()),
        ]);
    }

    // Cette methode affiche les categories disponibles pour une nouvelle offre.
    public function createPage(): void
    {
        $this->render('company.job-create', ['categories' => JobHuntData::categoriesList()]);
    }

    // Cette methode prepare le tableau de bord de l'entreprise.
    public function dashboard(): void
    {
        $id = $this->userId();
        $this->render('company.dashboard', [
            'metrics' => JobHuntData::companyMetrics($id),
            'jobs' => JobHuntData::companyJobs($id),
        ]);
    }

    // Cette methode publie une offre pour l'entreprise connectee.
    public function createJob(): void
    {
        $db = Database::connection();
        $query = $db->prepare('SELECT id FROM company_profiles WHERE user_id = ?');
        $query->execute([$this->userId()]);
        $companyId = $query->fetchColumn();

        $query = $db->prepare('SELECT id FROM job_categories WHERE name = ?');
        $query->execute([$_POST['category'] ?? '']);
        $categoryId = $query->fetchColumn();

        if (!$companyId || !$categoryId || empty($_POST['title']) || empty($_POST['summary'])) {
            $this->flash('Enter a title, description, and category for your job.', 'error');
            $this->redirect('company-job-create');
        }

        $query = $db->prepare(
            "INSERT INTO job_offers
            (company_id, category_id, title, summary, requirements, responsibilities, employment_type,
             experience_level, workplace_type, location, salary_min, salary_max, status, published_at)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'active', NOW())"
        );
        $query->execute([
            $companyId,
            $categoryId,
            $_POST['title'],
            $_POST['summary'],
            $_POST['requirements'] ?? '',
            $_POST['responsibilities'] ?? '',
            $_POST['employment_type'] ?? 'Full-time',
            $_POST['experience_level'] ?? 'Mid-level',
            $_POST['workplace_type'] ?? 'Remote',
            $_POST['location'] ?? '',
            $_POST['salary_min'] ?: null,
            $_POST['salary_max'] ?: null,
        ]);

        $this->flash('Job published.');
        $this->redirect('company-jobs');
    }

    // Cette methode change le statut d'une offre appartenant a l'entreprise.
    public function updateJobStatus(): void
    {
        $status = $_POST['status'] ?? '';
        if (!\in_array($status, ['active', 'paused', 'closed'], true)) {
            $this->flash('Choose a valid job status.', 'error');
            $this->redirect('company-jobs');
        }

        $query = Database::connection()->prepare(
            'UPDATE job_offers j JOIN company_profiles c ON c.id = j.company_id
             SET j.status = ? WHERE j.id = ? AND c.user_id = ?'
        );
        $query->execute([$status, $_POST['job_id'] ?? 0, $this->userId()]);
        $this->flash('Job status updated.');
        $this->redirect('company-jobs');
    }

    // Cette methode change le statut d'une candidature recue par l'entreprise.
    public function updateApplicationStatus(): void
    {
        $status = $_POST['status'] ?? '';
        $allowedStatuses = ['under_review', 'shortlisted', 'interview', 'accepted', 'rejected'];
        if (!\in_array($status, $allowedStatuses, true)) {
            $this->flash('Choose a valid application status.', 'error');
            $this->redirect('company-candidates');
        }

        $query = Database::connection()->prepare(
            'UPDATE applications a JOIN job_offers j ON j.id = a.job_id
             JOIN company_profiles c ON c.id = j.company_id
             SET a.status = ? WHERE a.id = ? AND c.user_id = ?'
        );
        $query->execute([$status, $_POST['application_id'] ?? 0, $this->userId()]);
        $this->flash('Application status updated.');
        $this->redirect('company-candidates');
    }

    // Cette methode enregistre les informations du profil de l'entreprise.
    public function saveProfile(): void
    {
        $name = $_POST['company_name'] ?? '';
        Database::connection()->prepare(
            'UPDATE company_profiles SET company_name = ?, industry = ?, company_size = ?,
             location = ?, website = ?, description = ? WHERE user_id = ?'
        )->execute([
            $name,
            $_POST['industry'] ?? '',
            $_POST['company_size'] ?? '',
            $_POST['location'] ?? '',
            $_POST['website'] ?? '',
            $_POST['description'] ?? '',
            $this->userId(),
        ]);

        $_SESSION['user']['name'] = $name;
        $this->flash('Company profile saved.');
        $this->redirect('company-profile-edit');
    }
}
