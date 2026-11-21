<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Database;
use App\Models\JobHuntData;
use PDOException;

class PageController extends Controller
{
    public function handle(string $page = 'home'): void
    {
        session_start();
        $this->checkAccount();

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !$this->verifyCsrf()) {
            $this->flash('Your session expired. Please try again.', 'error');
            $this->redirect($page);
        }
        if ($page === 'logout' && $_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('home');
        }

        $role = $_SESSION['user']['role'] ?? '';
        if (str_starts_with($page, 'candidate-') && $role !== 'candidate') {
            $this->redirect('signin');
        }
        if ($page !== 'company-profile' && str_starts_with($page, 'company-') && $role !== 'company') {
            $this->redirect('signin');
        }
        if (str_starts_with($page, 'admin-') && $role !== 'admin') {
            $this->redirect('signin');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->handleForm($page);
        }

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
            case 'about':
            case 'contact':
            case 'help':
            case 'privacy':
            case 'terms':
                $this->render('public.' . $page);
                break;
            case 'signin':
                $this->render('auth.signin');
                break;
            case 'account-type':
                $this->render('auth.choose-account');
                break;
            case 'register-candidate':
                $this->render('auth.candidate-register');
                break;
            case 'register-company':
                $this->render('auth.company-register');
                break;
            case 'forgot-password':
                $this->render('auth.forgot-password');
                break;
            case 'reset-password':
                $this->render('auth.reset-password', ['token' => $_GET['token'] ?? '']);
                break;
            case 'candidate-dashboard':
                $this->candidateDashboard();
                break;
            case 'candidate-jobs':
                $this->render('candidate.jobs', ['jobs' => JobHuntData::jobs($_GET)]);
                break;
            case 'candidate-saved':
                $this->render('candidate.saved-jobs', ['jobs' => JobHuntData::savedJobs($this->userId())]);
                break;
            case 'candidate-applications':
                $this->render('candidate.applications', ['applications' => JobHuntData::candidateApplications($this->userId())]);
                break;
            case 'candidate-profile':
                $this->render('candidate.profile', ['profile' => JobHuntData::candidateProfile($this->userId())]);
                break;
            case 'candidate-resumes':
                $this->render('candidate.resumes', ['resumes' => JobHuntData::candidateResumes($this->userId())]);
                break;
            case 'resume-download':
                $this->downloadResume();
                break;
            case 'company-dashboard':
                $this->companyDashboard();
                break;
            case 'company-profile-edit':
                $this->render('company.profile', ['profile' => JobHuntData::companyProfile($this->userId())]);
                break;
            case 'company-jobs':
                $this->render('company.jobs', ['jobs' => JobHuntData::companyJobs($this->userId())]);
                break;
            case 'company-candidates':
                $this->render('company.candidates', ['candidates' => JobHuntData::companyCandidates($this->userId())]);
                break;
            case 'company-job-create':
                $this->render('company.job-create', ['categories' => JobHuntData::categoriesList()]);
                break;
            case 'admin-dashboard':
                $this->adminDashboard();
                break;
            case 'admin-users':
                $this->render('admin.users', ['users' => JobHuntData::allUsers()]);
                break;
            case 'admin-categories':
                $this->render('admin.categories', ['categories' => JobHuntData::categoriesList(), 'skills' => JobHuntData::skills()]);
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

    private function handleForm(string $page): void
    {
        switch ($page) {
            case 'signin':
                $this->signIn();
                break;
            case 'register-candidate':
                $this->register('candidate');
                break;
            case 'register-company':
                $this->register('company');
                break;
            case 'forgot-password':
                $this->requestPasswordReset();
                break;
            case 'reset-password':
                $this->resetPassword();
                break;
            case 'job-details':
                if (($_POST['action'] ?? '') === 'apply') {
                    $this->apply();
                } else {
                    $this->saveJob();
                }
                break;
            case 'company-job-create':
                $this->createJob();
                break;
            case 'company-jobs':
                $this->updateJobStatus();
                break;
            case 'company-candidates':
                $this->updateApplicationStatus();
                break;
            case 'company-profile-edit':
                $this->saveCompanyProfile();
                break;
            case 'candidate-profile':
                $this->saveCandidateProfile();
                break;
            case 'candidate-resumes':
                $this->uploadResume();
                break;
            case 'candidate-saved':
                $this->removeSavedJob();
                break;
            case 'admin-users':
                $this->updateUserStatus();
                break;
            case 'admin-categories':
                $this->createCategory();
                break;
            case 'contact':
                $this->saveContactMessage();
                break;
            case 'logout':
                $this->logout();
                break;
        }
    }

    private function userId(): int
    {
        return (int) ($_SESSION['user']['id'] ?? 0);
    }

    private function checkAccount(): void
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

    private function signIn(): void
    {
        $db = Database::connection();
        $query = $db->prepare(
            'SELECT u.id, u.full_name, u.email, u.password_hash, u.status, r.name AS role
             FROM users u JOIN roles r ON r.id = u.role_id WHERE u.email = ?'
        );
        $query->execute([strtolower(trim($_POST['email'] ?? ''))]);
        $user = $query->fetch();

        if (!$user || $user['status'] !== 'active' || !password_verify($_POST['password'] ?? '', $user['password_hash'])) {
            $this->flash('Email or password is incorrect.', 'error');
            $this->redirect('signin');
        }

        session_regenerate_id(true);
        $_SESSION['user'] = [
            'id' => (int) $user['id'],
            'name' => $user['full_name'],
            'email' => $user['email'],
            'role' => $user['role'],
        ];
        $this->redirect($user['role'] . '-dashboard');
    }

    private function requestPasswordReset(): void
    {
        $email = strtolower(trim($_POST['email'] ?? ''));
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->flash('Enter a valid email address.', 'error');
            $this->redirect('forgot-password');
        }

        $db = Database::connection();
        $query = $db->prepare("SELECT id FROM users WHERE email = ? AND status = 'active'");
        $query->execute([$email]);
        $userId = $query->fetchColumn();
        if ($userId) {
            $token = bin2hex(random_bytes(32));
            $query = $db->prepare(
                'INSERT INTO password_reset_tokens (user_id, token_hash, expires_at)
                 VALUES (?, ?, DATE_ADD(NOW(), INTERVAL 1 HOUR))
                 ON DUPLICATE KEY UPDATE token_hash = VALUES(token_hash), expires_at = VALUES(expires_at)'
            );
            $query->execute([$userId, hash('sha256', $token)]);
            $url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME'])
                . '/index.php?page=reset-password&token=' . urlencode($token);
            if (!mail($email, 'Reset your JobHunt password', "Open this link to reset your password:\n\n" . $url)) {
                $this->flash('The reset email could not be sent. Check the mail settings in XAMPP.', 'error');
                $this->redirect('forgot-password');
            }
        }

        $this->flash('If the account exists, a reset link has been sent.');
        $this->redirect('signin');
    }

    private function resetPassword(): void
    {
        $password = $_POST['password'] ?? '';
        if (strlen($password) < 10 || $password !== ($_POST['password_confirmation'] ?? '')) {
            $this->flash('Enter matching passwords with at least 10 characters.', 'error');
            $this->redirect('reset-password', ['token' => $_POST['token'] ?? '']);
        }

        $db = Database::connection();
        $query = $db->prepare(
            'SELECT user_id FROM password_reset_tokens WHERE token_hash = ? AND expires_at > NOW()'
        );
        $query->execute([hash('sha256', $_POST['token'] ?? '')]);
        $userId = $query->fetchColumn();
        if (!$userId) {
            $this->flash('This password reset link is invalid or expired.', 'error');
            $this->redirect('forgot-password');
        }

        $db->prepare('UPDATE users SET password_hash = ? WHERE id = ?')
            ->execute([password_hash($password, PASSWORD_DEFAULT), $userId]);
        $db->prepare('DELETE FROM password_reset_tokens WHERE user_id = ?')->execute([$userId]);
        $this->flash('Password updated. You can now sign in.');
        $this->redirect('signin');
    }

    private function register(string $role): void
    {
        $name = trim($_POST['full_name'] ?? $_POST['company_name'] ?? '');
        $email = strtolower(trim($_POST['email'] ?? ''));
        $password = $_POST['password'] ?? '';

        if (!$name || !filter_var($email, FILTER_VALIDATE_EMAIL)
            || strlen($password) < 10 || $password !== ($_POST['password_confirmation'] ?? '')
            || empty($_POST['accept_terms'])) {
            $this->flash('Check your details, passwords, and agreement to the terms.', 'error');
            $this->redirect('register-' . $role);
        }

        $db = Database::connection();
        $query = $db->prepare('SELECT id FROM roles WHERE name = ?');
        $query->execute([$role]);
        $roleId = $query->fetchColumn();

        try {
            $db->beginTransaction();
            $query = $db->prepare(
                "INSERT INTO users (role_id, full_name, email, password_hash, status)
                 VALUES (?, ?, ?, ?, 'active')"
            );
            $query->execute([$roleId, $name, $email, password_hash($password, PASSWORD_DEFAULT)]);
            $userId = (int) $db->lastInsertId();

            if ($role === 'candidate') {
                $db->prepare('INSERT INTO candidate_profiles (user_id) VALUES (?)')->execute([$userId]);
                $db->prepare('INSERT INTO user_profiles (user_id) VALUES (?)')->execute([$userId]);
            } else {
                $query = $db->prepare(
                    "INSERT INTO company_profiles (user_id, company_name, industry, location, website, verification_status)
                     VALUES (?, ?, ?, ?, ?, 'pending')"
                );
                $query->execute([
                    $userId, $name, $_POST['industry'] ?? '', $_POST['location'] ?? '', $_POST['website'] ?? '',
                ]);
                $companyId = (int) $db->lastInsertId();
                $db->prepare('INSERT INTO company_members (company_id, user_id, role, is_owner) VALUES (?, ?, ?, 1)')
                    ->execute([$companyId, $userId, 'owner']);
                $db->prepare('INSERT INTO user_profiles (user_id) VALUES (?)')->execute([$userId]);
            }
            $db->commit();
        } catch (PDOException $error) {
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

    private function apply(): void
    {
        if (($_SESSION['user']['role'] ?? '') !== 'candidate') {
            $this->flash('Sign in as a candidate to apply.', 'error');
            $this->redirect('signin');
        }
        $db = Database::connection();
        $resumeId = $_POST['resume_id'] ?: null;
        if ($resumeId) {
            $query = $db->prepare('SELECT id FROM resumes WHERE id = ? AND user_id = ?');
            $query->execute([$resumeId, $this->userId()]);
            if (!$query->fetchColumn()) {
                $this->flash('Choose one of your resumes.', 'error');
                $this->redirect('jobs');
            }
        }
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
        $this->flash($query->rowCount() ? 'Application sent.' : 'This job is no longer available.', $query->rowCount() ? 'success' : 'error');
        $this->redirect('candidate-applications');
    }

    private function saveJob(): void
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

    private function createJob(): void
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
            $companyId, $categoryId, $_POST['title'], $_POST['summary'],
            $_POST['requirements'] ?? '', $_POST['responsibilities'] ?? '',
            $_POST['employment_type'] ?? 'Full-time', $_POST['experience_level'] ?? 'Mid-level',
            $_POST['workplace_type'] ?? 'Remote', $_POST['location'] ?? '',
            $_POST['salary_min'] ?: null, $_POST['salary_max'] ?: null,
        ]);
        $this->flash('Job published.');
        $this->redirect('company-jobs');
    }

    private function updateJobStatus(): void
    {
        if (!in_array($_POST['status'] ?? '', ['active', 'paused', 'closed'], true)) {
            $this->flash('Choose a valid job status.', 'error');
            $this->redirect('company-jobs');
        }
        $query = Database::connection()->prepare(
            'UPDATE job_offers j JOIN company_profiles c ON c.id = j.company_id
             SET j.status = ? WHERE j.id = ? AND c.user_id = ?'
        );
        $query->execute([$_POST['status'] ?? 'active', $_POST['job_id'] ?? 0, $this->userId()]);
        $this->flash('Job status updated.');
        $this->redirect('company-jobs');
    }

    private function updateApplicationStatus(): void
    {
        if (!in_array($_POST['status'] ?? '', ['under_review', 'shortlisted', 'interview', 'accepted', 'rejected'], true)) {
            $this->flash('Choose a valid application status.', 'error');
            $this->redirect('company-candidates');
        }
        $query = Database::connection()->prepare(
            'UPDATE applications a JOIN job_offers j ON j.id = a.job_id
             JOIN company_profiles c ON c.id = j.company_id
             SET a.status = ? WHERE a.id = ? AND c.user_id = ?'
        );
        $query->execute([$_POST['status'] ?? 'under_review', $_POST['application_id'] ?? 0, $this->userId()]);
        $this->flash('Application status updated.');
        $this->redirect('company-candidates');
    }

    private function saveCandidateProfile(): void
    {
        $db = Database::connection();
        $db->prepare('UPDATE users SET full_name = ? WHERE id = ?')
            ->execute([$_POST['full_name'] ?? '', $this->userId()]);
        $db->prepare(
            'INSERT INTO candidate_profiles (user_id, headline, professional_summary) VALUES (?, ?, ?)
             ON DUPLICATE KEY UPDATE headline = VALUES(headline), professional_summary = VALUES(professional_summary)'
        )->execute([$this->userId(), $_POST['headline'] ?? '', $_POST['professional_summary'] ?? '']);
        $db->prepare(
            'INSERT INTO user_profiles (user_id, phone, location) VALUES (?, ?, ?)
             ON DUPLICATE KEY UPDATE phone = VALUES(phone), location = VALUES(location)'
        )->execute([$this->userId(), $_POST['phone'] ?? '', $_POST['location'] ?? '']);
        $_SESSION['user']['name'] = $_POST['full_name'] ?? '';
        $this->flash('Profile saved.');
        $this->redirect('candidate-profile');
    }

    private function saveCompanyProfile(): void
    {
        Database::connection()->prepare(
            'UPDATE company_profiles SET company_name = ?, industry = ?, company_size = ?,
             location = ?, website = ?, description = ? WHERE user_id = ?'
        )->execute([
            $_POST['company_name'] ?? '', $_POST['industry'] ?? '', $_POST['company_size'] ?? '',
            $_POST['location'] ?? '', $_POST['website'] ?? '', $_POST['description'] ?? '', $this->userId(),
        ]);
        $_SESSION['user']['name'] = $_POST['company_name'] ?? '';
        $this->flash('Company profile saved.');
        $this->redirect('company-profile-edit');
    }

    private function uploadResume(): void
    {
        $file = $_FILES['resume'] ?? null;
        if (!$file || $file['error'] !== UPLOAD_ERR_OK || $file['size'] > 5 * 1024 * 1024) {
            $this->flash('Choose a resume file smaller than 5 MB.', 'error');
            $this->redirect('candidate-resumes');
        }

        $types = ['application/pdf' => 'pdf', 'application/msword' => 'doc',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'docx'];
        $type = (new \finfo(FILEINFO_MIME_TYPE))->file($file['tmp_name']);
        if (!isset($types[$type])) {
            $this->flash('Only PDF, DOC, or DOCX files are accepted.', 'error');
            $this->redirect('candidate-resumes');
        }

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

    private function downloadResume(): void
    {
        $query = Database::connection()->prepare('SELECT file_name, file_path, file_type FROM resumes WHERE id = ? AND user_id = ?');
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

    private function removeSavedJob(): void
    {
        Database::connection()->prepare('DELETE FROM saved_jobs WHERE user_id = ? AND job_id = ?')
            ->execute([$this->userId(), $_POST['job_id'] ?? 0]);
        $this->flash('Saved job removed.');
        $this->redirect('candidate-saved');
    }

    private function updateUserStatus(): void
    {
        if (!in_array($_POST['status'] ?? '', ['active', 'suspended'], true)) {
            $this->flash('Choose a valid user status.', 'error');
            $this->redirect('admin-users');
        }
        Database::connection()->prepare('UPDATE users SET status = ? WHERE id = ? AND id != ?')
            ->execute([$_POST['status'] ?? 'active', $_POST['user_id'] ?? 0, $this->userId()]);
        $this->flash('User status updated.');
        $this->redirect('admin-users');
    }

    private function createCategory(): void
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

    private function saveContactMessage(): void
    {
        if (empty($_POST['full_name']) || !filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL) || empty($_POST['message'])) {
            $this->flash('Complete your name, email, and message.', 'error');
            $this->redirect('contact');
        }
        Database::connection()->prepare(
            'INSERT INTO contact_messages (full_name, email, message) VALUES (?, ?, ?)'
        )->execute([trim($_POST['full_name'] ?? ''), trim($_POST['email'] ?? ''), trim($_POST['message'] ?? '')]);
        $this->flash('Thanks, your message has been received.');
        $this->redirect('contact');
    }

    private function showJob(): void
    {
        $job = JobHuntData::jobById((int) ($_GET['id'] ?? 0));
        if (!$job) {
            $this->redirect('jobs');
        }
        $this->render('public.job-details', [
            'job' => $job,
            'user' => $_SESSION['user'] ?? null,
            'resumes' => ($_SESSION['user']['role'] ?? '') === 'candidate'
                ? JobHuntData::candidateResumes($this->userId())
                : [],
        ]);
    }

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

    private function candidateDashboard(): void
    {
        $id = $this->userId();
        $this->render('candidate.dashboard', [
            'metrics' => JobHuntData::candidateMetrics($id),
            'applications' => JobHuntData::candidateApplications($id),
            'notifications' => [],
        ]);
    }

    private function companyDashboard(): void
    {
        $id = $this->userId();
        $this->render('company.dashboard', [
            'metrics' => JobHuntData::companyMetrics($id),
            'jobs' => JobHuntData::companyJobs($id),
        ]);
    }

    private function adminDashboard(): void
    {
        $this->render('admin.dashboard', [
            'metrics' => JobHuntData::adminMetrics(),
            'users' => array_slice(JobHuntData::allUsers(), 0, 5),
            'jobs' => JobHuntData::jobs(),
            'messages' => JobHuntData::contactMessages(),
        ]);
    }

    private function logout(): void
    {
        $_SESSION = [];
        session_destroy();
        $this->redirect('home');
    }
}
