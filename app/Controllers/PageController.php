<?php
// Ce fichier choisit la page a afficher et envoie les actions au bon controleur.

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Database;
use App\Models\JobHuntData;

class PageController extends Controller
{
    private AuthController $auth;
    private CandidateController $candidate;
    private CompanyController $company;
    private AdminController $admin;

    // Cette methode prepare les controleurs responsables de chaque partie du site.
    public function __construct()
    {
        $this->auth = new AuthController();
        $this->candidate = new CandidateController();
        $this->company = new CompanyController();
        $this->admin = new AdminController();
    }

    // Cette methode verifie la session et affiche la page demandee.
    public function handle(string $page = 'home'): void
    {
        session_start();
        $this->auth->checkAccount();

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !$this->verifyCsrf()) {
            $this->flash('Your session expired. Please try again.', 'error');
            $this->redirect($page);
        }

        if ($page === 'logout' && $_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('home');
        }

        $this->checkPageAccess($page);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->handleForm($page);
        }

        // Ces pages ne demandent aucune donnee supplementaire.
        $simplePages = [
            'about' => 'public.about',
            'contact' => 'public.contact',
            'help' => 'public.help',
            'privacy' => 'public.privacy',
            'terms' => 'public.terms',
            'signin' => 'auth.signin',
            'account-type' => 'auth.choose-account',
            'register-candidate' => 'auth.candidate-register',
            'register-company' => 'auth.company-register',
            'unauthorized' => 'auth.unauthorized',
        ];
        if (isset($simplePages[$page])) {
            $this->render($simplePages[$page]);
            return;
        }

        // Ces pages chargent les donnees utiles avant d'afficher leur vue.
        switch ($page) {
            case 'jobs':
                $this->render('public.jobs', [
                    'jobs' => JobHuntData::jobs($_GET),
                    'filters' => $_GET,
                ]);
                break;
            case 'job-details':
                $this->showJob();
                break;
            case 'companies':
                $this->render('public.companies', ['companies' => JobHuntData::companyList()]);
                break;
            case 'company-profile':
                $this->showCompany();
                break;
            case 'candidate-dashboard':
                $this->candidate->dashboard();
                break;
            case 'candidate-jobs':
                $this->candidate->jobs();
                break;
            case 'candidate-saved':
                $this->candidate->savedJobs();
                break;
            case 'candidate-applications':
                $this->candidate->applications();
                break;
            case 'candidate-profile':
                $this->candidate->profile();
                break;
            case 'candidate-resumes':
                $this->candidate->resumes();
                break;
            case 'resume-download':
                $this->candidate->downloadResume();
                break;
            case 'company-dashboard':
                $this->company->dashboard();
                break;
            case 'company-profile-edit':
                $this->company->profile();
                break;
            case 'company-jobs':
                $this->company->jobs();
                break;
            case 'company-candidates':
                $this->company->candidates();
                break;
            case 'company-job-create':
                $this->company->createPage();
                break;
            case 'admin-dashboard':
                $this->admin->dashboard();
                break;
            case 'admin-users':
                $this->admin->users();
                break;
            case 'admin-categories':
                $this->admin->categories();
                break;
            case 'logout':
                $this->logout();
                break;
            default:
                $this->render('public.home', [
                    'jobs' => JobHuntData::jobs(),
                    'companies' => JobHuntData::companyList(),
                    'metrics' => JobHuntData::publicMetrics(),
                ]);
        }
    }

    // Cette methode envoie chaque formulaire a son controleur de domaine.
    private function handleForm(string $page): void
    {
        switch ($page) {
            case 'signin':
                $this->auth->signIn();
                break;
            case 'register-candidate':
                $this->auth->register('candidate');
                break;
            case 'register-company':
                $this->auth->register('company');
                break;
            case 'job-details':
                if (($_POST['action'] ?? '') === 'apply') {
                    $this->candidate->apply();
                } else {
                    $this->candidate->saveJob();
                }
                break;
            case 'candidate-profile':
                $this->candidate->saveProfile();
                break;
            case 'candidate-resumes':
                $this->candidate->uploadResume();
                break;
            case 'candidate-saved':
                $this->candidate->removeSavedJob();
                break;
            case 'company-job-create':
                $this->company->createJob();
                break;
            case 'company-jobs':
                $this->company->updateJobStatus();
                break;
            case 'company-candidates':
                $this->company->updateApplicationStatus();
                break;
            case 'company-profile-edit':
                $this->company->saveProfile();
                break;
            case 'admin-users':
                $this->admin->updateUserStatus();
                break;
            case 'admin-categories':
                $this->admin->createCategory();
                break;
            case 'contact':
                $this->saveContactMessage();
                break;
            case 'logout':
                $this->logout();
                break;
        }
    }

    // Cette methode bloque les pages reservees a un role different.
    private function checkPageAccess(string $page): void
    {
        $role = $_SESSION['user']['role'] ?? '';
        $requiredRole = '';

        if (str_starts_with($page, 'candidate-') || $page === 'resume-download') {
            $requiredRole = 'candidate';
        } elseif ($page !== 'company-profile' && str_starts_with($page, 'company-')) {
            $requiredRole = 'company';
        } elseif (str_starts_with($page, 'admin-')) {
            $requiredRole = 'admin';
        }

        if ($requiredRole !== '' && $role !== $requiredRole) {
            $this->redirect($role === '' ? 'signin' : 'unauthorized');
        }
    }

    // Cette methode charge une offre et les CV du candidat connecte, s'il y en a un.
    private function showJob(): void
    {
        $job = JobHuntData::jobById((int) ($_GET['id'] ?? 0));
        if (!$job) {
            $this->redirect('jobs');
        }

        $resumes = [];
        if (($_SESSION['user']['role'] ?? '') === 'candidate') {
            $resumes = JobHuntData::candidateResumes($this->userId());
        }

        $this->render('public.job-details', [
            'job' => $job,
            'user' => $_SESSION['user'] ?? null,
            'resumes' => $resumes,
        ]);
    }

    // Cette methode charge une entreprise et ses offres actives.
    private function showCompany(): void
    {
        $company = JobHuntData::companyById((int) ($_GET['id'] ?? 0));
        if (!$company) {
            $this->redirect('companies');
        }

        $this->render('public.company-profile', [
            'company' => $company,
            'jobs' => JobHuntData::jobsByCompany((int) $company['id']),
        ]);
    }

    // Cette methode verifie puis enregistre un message du formulaire de contact.
    private function saveContactMessage(): void
    {
        if (empty($_POST['full_name']) || !filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL)
            || empty($_POST['message'])) {
            $this->flash('Complete your name, email, and message.', 'error');
            $this->redirect('contact');
        }

        Database::connection()->prepare(
            'INSERT INTO contact_messages (full_name, email, message) VALUES (?, ?, ?)'
        )->execute([
            trim($_POST['full_name']),
            trim($_POST['email']),
            trim($_POST['message']),
        ]);
        $this->flash('Thanks, your message has been received.');
        $this->redirect('contact');
    }

    // Cette methode termine la session et retourne a l'accueil.
    private function logout(): void
    {
        $_SESSION = [];
        session_destroy();
        $this->redirect('home');
    }
}
