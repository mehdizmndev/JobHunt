<?php

namespace App\Models;

use App\Core\Database;

class JobHuntData
{
    public static function jobs(array $filters = []): array
    {
        $sql = "SELECT j.id, j.title, c.company_name AS company, j.location,
                    j.employment_type AS type, j.workplace_type AS workplace,
                    j.salary_min, j.salary_max, j.currency, j.experience_level AS experience,
                    j.summary AS tagline, j.responsibilities, j.requirements, j.benefits,
                    j.published_at, cat.name AS category
                FROM job_offers j
                JOIN company_profiles c ON c.id = j.company_id
                JOIN job_categories cat ON cat.id = j.category_id
                WHERE j.status = 'active'
                AND (j.application_deadline IS NULL OR j.application_deadline >= CURRENT_DATE)";
        $values = [];

        if (!empty($filters['keyword'])) {
            $sql .= ' AND (j.title LIKE ? OR j.summary LIKE ? OR cat.name LIKE ?)';
            $keyword = '%' . $filters['keyword'] . '%';
            $values = [$keyword, $keyword, $keyword];
        }
        if (!empty($filters['location'])) {
            $sql .= ' AND j.location LIKE ?';
            $values[] = '%' . $filters['location'] . '%';
        }
        if (!empty($filters['employment_type'])) {
            $sql .= ' AND j.employment_type = ?';
            $values[] = $filters['employment_type'];
        }
        if (!empty($filters['workplace_type'])) {
            $sql .= ' AND j.workplace_type = ?';
            $values[] = $filters['workplace_type'];
        }

        $sql .= ' ORDER BY j.created_at DESC';
        $query = Database::connection()->prepare($sql);
        $query->execute($values);
        $jobs = $query->fetchAll();

        foreach ($jobs as &$job) {
            $job['salary'] = $job['salary_min'] && $job['salary_max']
                ? number_format($job['salary_min']) . ' - ' . number_format($job['salary_max']) . ' ' . $job['currency']
                : 'Salary not disclosed';
            $job['skills'] = self::jobSkills((int) $job['id']);
            $job['posted'] = date('M j, Y', strtotime($job['published_at'] ?? 'now'));
        }
        unset($job);

        return $jobs;
    }

    public static function jobById(int $id): ?array
    {
        foreach (self::jobs() as $job) {
            if ((int) $job['id'] === $id) {
                return $job;
            }
        }
        return null;
    }

    public static function jobSkills(int $jobId): array
    {
        $query = Database::connection()->prepare(
            'SELECT s.name FROM job_skills js JOIN skills s ON s.id = js.skill_id WHERE js.job_id = ?'
        );
        $query->execute([$jobId]);
        return $query->fetchAll(\PDO::FETCH_COLUMN);
    }

    public static function companyList(): array
    {
        return Database::connection()->query(
            'SELECT id, company_name AS name, industry, company_size AS size, location, website, description
             FROM company_profiles ORDER BY company_name'
        )->fetchAll();
    }

    public static function companyById(int $id): ?array
    {
        $query = Database::connection()->prepare(
            'SELECT id, company_name AS name, industry, company_size AS size, location, website, description
             FROM company_profiles WHERE id = ?'
        );
        $query->execute([$id]);
        return $query->fetch() ?: null;
    }

    public static function jobsByCompany(int $companyId): array
    {
        $query = Database::connection()->prepare(
            "SELECT id, title FROM job_offers WHERE company_id = ? AND status = 'active'"
        );
        $query->execute([$companyId]);
        return $query->fetchAll();
    }

    public static function publicMetrics(): array
    {
        $db = Database::connection();
        return [
            'jobs' => $db->query("SELECT COUNT(*) FROM job_offers WHERE status = 'active'")->fetchColumn(),
            'companies' => $db->query('SELECT COUNT(*) FROM company_profiles')->fetchColumn(),
            'candidates' => $db->query(
                "SELECT COUNT(*) FROM users u JOIN roles r ON r.id = u.role_id WHERE r.name = 'candidate'"
            )->fetchColumn(),
        ];
    }

    public static function categoriesList(): array
    {
        return Database::connection()->query(
            'SELECT c.name, COUNT(j.id) AS count FROM job_categories c
             LEFT JOIN job_offers j ON j.category_id = c.id GROUP BY c.id ORDER BY c.name'
        )->fetchAll();
    }

    public static function skills(): array
    {
        return Database::connection()->query('SELECT name FROM skills ORDER BY name')->fetchAll(\PDO::FETCH_COLUMN);
    }

    public static function candidateMetrics(int $userId): array
    {
        $query = Database::connection()->prepare(
            "SELECT COUNT(*) AS total,
                    SUM(status IN ('submitted','under_review')) AS review_count,
                    SUM(status = 'shortlisted') AS shortlisted_count,
                    SUM(status = 'interview') AS interview_count
             FROM applications WHERE user_id = ?"
        );
        $query->execute([$userId]);
        $counts = $query->fetch();
        return [
            ['label' => 'Applications', 'value' => $counts['total'] ?? 0, 'trend' => 'Total sent'],
            ['label' => 'Under review', 'value' => $counts['review_count'] ?? 0, 'trend' => 'In progress'],
            ['label' => 'Shortlisted', 'value' => $counts['shortlisted_count'] ?? 0, 'trend' => 'Positive replies'],
            ['label' => 'Interviews', 'value' => $counts['interview_count'] ?? 0, 'trend' => 'Next steps'],
        ];
    }

    public static function candidateApplications(int $userId): array
    {
        $query = Database::connection()->prepare(
            'SELECT c.company_name AS company, j.title AS position, j.id AS job_id,
                    a.created_at AS date, a.status
             FROM applications a JOIN job_offers j ON j.id = a.job_id
             JOIN company_profiles c ON c.id = j.company_id
             WHERE a.user_id = ? ORDER BY a.created_at DESC'
        );
        $query->execute([$userId]);
        return $query->fetchAll();
    }

    public static function candidateProfile(int $userId): array
    {
        $query = Database::connection()->prepare(
            'SELECT u.full_name, u.email, up.phone, up.location, cp.headline, cp.professional_summary
             FROM users u LEFT JOIN user_profiles up ON up.user_id = u.id
             LEFT JOIN candidate_profiles cp ON cp.user_id = u.id WHERE u.id = ?'
        );
        $query->execute([$userId]);
        return $query->fetch() ?: [];
    }

    public static function candidateResumes(int $userId): array
    {
        $query = Database::connection()->prepare(
            'SELECT id, file_name, file_type, is_primary, created_at FROM resumes
             WHERE user_id = ? ORDER BY created_at DESC'
        );
        $query->execute([$userId]);
        return $query->fetchAll();
    }

    public static function savedJobs(int $userId): array
    {
        $query = Database::connection()->prepare(
            'SELECT j.id, j.title, c.company_name AS company, j.location,
                    j.employment_type AS type, j.workplace_type AS workplace,
                    j.salary_min, j.salary_max, j.currency
             FROM saved_jobs s JOIN job_offers j ON j.id = s.job_id
             JOIN company_profiles c ON c.id = j.company_id
             WHERE s.user_id = ? ORDER BY s.saved_at DESC'
        );
        $query->execute([$userId]);
        return $query->fetchAll();
    }

    public static function companyProfile(int $userId): array
    {
        $query = Database::connection()->prepare(
            'SELECT company_name, industry, company_size, location, website, description
             FROM company_profiles WHERE user_id = ?'
        );
        $query->execute([$userId]);
        return $query->fetch() ?: [];
    }

    public static function companyJobs(int $userId): array
    {
        $query = Database::connection()->prepare(
            'SELECT j.id, j.title, j.location, j.status, COUNT(a.id) AS applicant_count
             FROM job_offers j JOIN company_profiles c ON c.id = j.company_id
             LEFT JOIN applications a ON a.job_id = j.id
             WHERE c.user_id = ? GROUP BY j.id ORDER BY j.created_at DESC'
        );
        $query->execute([$userId]);
        return $query->fetchAll();
    }

    public static function companyCandidates(int $userId): array
    {
        $query = Database::connection()->prepare(
            'SELECT u.full_name AS name, j.title AS role, a.status, a.id
             FROM applications a JOIN job_offers j ON j.id = a.job_id
             JOIN company_profiles c ON c.id = j.company_id
             JOIN users u ON u.id = a.user_id WHERE c.user_id = ?
             ORDER BY a.created_at DESC'
        );
        $query->execute([$userId]);
        return $query->fetchAll();
    }

    public static function companyMetrics(int $userId): array
    {
        $query = Database::connection()->prepare(
            "SELECT COUNT(DISTINCT CASE WHEN j.status = 'active' THEN j.id END) AS jobs,
                    COUNT(a.id) AS applications,
                    SUM(a.status IN ('submitted','under_review')) AS reviewing,
                    SUM(a.status = 'shortlisted') AS shortlisted
             FROM company_profiles c LEFT JOIN job_offers j ON j.company_id = c.id
             LEFT JOIN applications a ON a.job_id = j.id WHERE c.user_id = ?"
        );
        $query->execute([$userId]);
        $counts = $query->fetch();
        return [
            ['label' => 'Job offers', 'value' => $counts['jobs'] ?? 0, 'trend' => 'Your listings'],
            ['label' => 'Applications', 'value' => $counts['applications'] ?? 0, 'trend' => 'Received'],
            ['label' => 'Under review', 'value' => $counts['reviewing'] ?? 0, 'trend' => 'Candidates'],
            ['label' => 'Shortlisted', 'value' => $counts['shortlisted'] ?? 0, 'trend' => 'Candidates'],
        ];
    }

    public static function allUsers(): array
    {
        return Database::connection()->query(
            'SELECT u.id, u.full_name AS name, u.email, r.name AS type, u.status
             FROM users u JOIN roles r ON r.id = u.role_id ORDER BY u.created_at DESC'
        )->fetchAll();
    }

    public static function contactMessages(): array
    {
        return Database::connection()->query(
            'SELECT full_name, email, message, created_at
             FROM contact_messages ORDER BY created_at DESC LIMIT 10'
        )->fetchAll();
    }

    public static function adminMetrics(): array
    {
        $db = Database::connection();
        return [
            ['label' => 'Users', 'value' => $db->query('SELECT COUNT(*) FROM users')->fetchColumn(), 'trend' => 'Registered'],
            ['label' => 'Candidates', 'value' => $db->query("SELECT COUNT(*) FROM users u JOIN roles r ON r.id=u.role_id WHERE r.name='candidate'")->fetchColumn(), 'trend' => 'Accounts'],
            ['label' => 'Companies', 'value' => $db->query('SELECT COUNT(*) FROM company_profiles')->fetchColumn(), 'trend' => 'Registered'],
            ['label' => 'Job offers', 'value' => $db->query("SELECT COUNT(*) FROM job_offers WHERE status='active'")->fetchColumn(), 'trend' => 'Published'],
        ];
    }
}
