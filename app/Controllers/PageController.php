<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\JobHuntData;

class PageController extends Controller
{
    public function handle(string $page = 'home'): void
    {
        $route = strtolower(trim($page, '/')) ?: 'home';

        $routes = [
            'home' => 'home',
            'jobs' => 'jobs',
            'job-details' => 'jobDetails',
            'companies' => 'companies',
            'company-profile' => 'companyProfile',
            'about' => 'about',
            'contact' => 'contact',
            'help' => 'help',
            'privacy' => 'privacy',
            'terms' => 'terms',
            'signin' => 'signin',
            'account-type' => 'chooseAccount',
            'register-candidate' => 'registerCandidate',
            'register-company' => 'registerCompany',
            'forgot-password' => 'forgotPassword',
            'unauthorized' => 'unauthorized',
            'candidate-dashboard' => 'candidateDashboard',
            'candidate-jobs' => 'candidateJobs',
            'candidate-applications' => 'candidateApplications',
            'candidate-profile' => 'candidateProfile',
            'candidate-resumes' => 'candidateResumes',
            'company-dashboard' => 'companyDashboard',
            'company-jobs' => 'companyJobs',
            'company-candidates' => 'companyCandidates',
            'company-job-create' => 'companyJobCreate',
            'admin-dashboard' => 'adminDashboard',
            'admin-users' => 'adminUsers',
            'admin-categories' => 'adminCategories',
        ];

        $method = $routes[$route] ?? 'home';
        $this->$method();
    }

    public function home(): void
    {
        $this->render('public.home', [
            'jobs' => JobHuntData::jobs(),
            'companies' => JobHuntData::companies(),
        ]);
    }

    public function jobs(): void
    {
        $this->render('public.jobs', ['jobs' => JobHuntData::jobs()]);
    }

    public function jobDetails(): void
    {
        $this->render('public.job-details', ['job' => JobHuntData::jobs()[0]]);
    }

    public function companies(): void
    {
        $this->render('public.companies', ['companies' => JobHuntData::companies()]);
    }

    public function companyProfile(): void
    {
        $this->render('public.company-profile', ['company' => JobHuntData::companies()[0]]);
    }

    public function about(): void
    {
        $this->render('public.about');
    }

    public function contact(): void
    {
        $this->render('public.contact');
    }

    public function help(): void
    {
        $this->render('public.help');
    }

    public function privacy(): void
    {
        $this->render('public.privacy');
    }

    public function terms(): void
    {
        $this->render('public.terms');
    }

    public function signin(): void
    {
        $this->render('auth.signin');
    }

    public function chooseAccount(): void
    {
        $this->render('auth.choose-account');
    }

    public function registerCandidate(): void
    {
        $this->render('auth.candidate-register');
    }

    public function registerCompany(): void
    {
        $this->render('auth.company-register');
    }

    public function forgotPassword(): void
    {
        $this->render('auth.forgot-password');
    }

    public function unauthorized(): void
    {
        $this->render('auth.unauthorized');
    }

    public function candidateDashboard(): void
    {
        $this->render('candidate.dashboard', ['metrics' => JobHuntData::candidateMetrics(), 'applications' => JobHuntData::applications(), 'notifications' => JobHuntData::notifications()]);
    }

    public function candidateJobs(): void
    {
        $this->render('candidate.jobs', ['jobs' => JobHuntData::jobs()]);
    }

    public function candidateApplications(): void
    {
        $this->render('candidate.applications', ['applications' => JobHuntData::applications()]);
    }

    public function candidateProfile(): void
    {
        $this->render('candidate.profile');
    }

    public function candidateResumes(): void
    {
        $this->render('candidate.resumes');
    }

    public function companyDashboard(): void
    {
        $this->render('company.dashboard', ['metrics' => JobHuntData::companyMetrics(), 'jobs' => JobHuntData::jobs()]);
    }

    public function companyJobs(): void
    {
        $this->render('company.jobs', ['jobs' => JobHuntData::jobs()]);
    }

    public function companyCandidates(): void
    {
        $this->render('company.candidates', ['jobs' => JobHuntData::jobs()]);
    }

    public function companyJobCreate(): void
    {
        $this->render('company.job-create');
    }

    public function adminDashboard(): void
    {
        $this->render('admin.dashboard', ['metrics' => JobHuntData::adminMetrics(), 'users' => JobHuntData::users(), 'jobs' => JobHuntData::jobs()]);
    }

    public function adminUsers(): void
    {
        $this->render('admin.users', ['users' => JobHuntData::users()]);
    }

    public function adminCategories(): void
    {
        $this->render('admin.categories', ['categories' => JobHuntData::categories(), 'skills' => JobHuntData::skills()]);
    }
}
