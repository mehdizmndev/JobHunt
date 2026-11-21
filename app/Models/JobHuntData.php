<?php

namespace App\Models;

class JobHuntData
{
    public static function jobs(): array
    {
        return [
            [
                'title' => 'Senior Product Designer',
                'company' => 'Northstar Labs',
                'location' => 'Remote · US',
                'type' => 'Full-time',
                'workplace' => 'Remote',
                'salary' => '$120k - $150k',
                'experience' => 'Senior',
                'tagline' => 'Design delightful hiring experiences for the next generation of talent.',
                'skills' => ['Figma', 'UX Research', 'Design Systems'],
                'posted' => '2 days ago',
            ],
            [
                'title' => 'Frontend Engineer',
                'company' => 'Asteria Cloud',
                'location' => 'New York, NY',
                'type' => 'Full-time',
                'workplace' => 'Hybrid',
                'salary' => '$110k - $140k',
                'experience' => 'Mid-Level',
                'tagline' => 'Build product features that empower global hiring teams.',
                'skills' => ['JavaScript', 'CSS', 'React'],
                'posted' => '1 week ago',
            ],
            [
                'title' => 'Senior Data Analyst',
                'company' => 'BluePeak',
                'location' => 'Austin, TX',
                'type' => 'Hybrid',
                'workplace' => 'Hybrid',
                'salary' => '$100k - $130k',
                'experience' => 'Senior',
                'tagline' => 'Turn candidate and hiring data into evidence-backed recommendations.',
                'skills' => ['SQL', 'Analytics', 'Python'],
                'posted' => '3 days ago',
            ],
            [
                'title' => 'Recruitment Operations Lead',
                'company' => 'Mercury Talent',
                'location' => 'Chicago, IL',
                'type' => 'Full-time',
                'workplace' => 'On-site',
                'salary' => '$95k - $120k',
                'experience' => 'Lead',
                'tagline' => 'Drive hiring operations and candidate experience at scale.',
                'skills' => ['Recruiting', 'Operations', 'Stakeholder Management'],
                'posted' => '5 days ago',
            ],
            [
                'title' => 'PHP Backend Engineer',
                'company' => 'PixelForge',
                'location' => 'Remote · Europe',
                'type' => 'Contract',
                'workplace' => 'Remote',
                'salary' => '$80k - $105k',
                'experience' => 'Mid-Level',
                'tagline' => 'Ship secure, scalable backend systems for talent marketplaces.',
                'skills' => ['PHP', 'MySQL', 'API Design'],
                'posted' => '6 days ago',
            ],
        ];
    }

    public static function companies(): array
    {
        return [
            ['name' => 'Northstar Labs', 'industry' => 'SaaS', 'size' => '201-500', 'location' => 'San Francisco, CA'],
            ['name' => 'Asteria Cloud', 'industry' => 'Cloud', 'size' => '501-1,000', 'location' => 'New York, NY'],
            ['name' => 'BluePeak', 'industry' => 'Analytics', 'size' => '51-200', 'location' => 'Austin, TX'],
            ['name' => 'Mercury Talent', 'industry' => 'Recruitment', 'size' => '101-500', 'location' => 'Chicago, IL'],
        ];
    }

    public static function candidateMetrics(): array
    {
        return [
            ['label' => 'Total Applications', 'value' => '38', 'trend' => '+12%'],
            ['label' => 'Under Review', 'value' => '9', 'trend' => '+3'],
            ['label' => 'Shortlisted', 'value' => '6', 'trend' => '+2'],
            ['label' => 'Interviews', 'value' => '3', 'trend' => '+1'],
        ];
    }

    public static function applications(): array
    {
        return [
            ['company' => 'Northstar Labs', 'position' => 'Senior Product Designer', 'date' => 'Jun 04, 2026', 'type' => 'Full-time', 'status' => 'Under Review', 'updated' => '2h ago'],
            ['company' => 'Asteria Cloud', 'position' => 'Frontend Engineer', 'date' => 'May 31, 2026', 'type' => 'Full-time', 'status' => 'Shortlisted', 'updated' => '1d ago'],
            ['company' => 'BluePeak', 'position' => 'Data Analyst', 'date' => 'May 20, 2026', 'type' => 'Hybrid', 'status' => 'Interview', 'updated' => '3d ago'],
        ];
    }

    public static function companyMetrics(): array
    {
        return [
            ['label' => 'Active Job Offers', 'value' => '18', 'trend' => '+2'],
            ['label' => 'Total Applications', 'value' => '342', 'trend' => '+28'],
            ['label' => 'Candidates Under Review', 'value' => '74', 'trend' => '+11'],
            ['label' => 'Shortlisted Candidates', 'value' => '23', 'trend' => '+5'],
        ];
    }

    public static function adminMetrics(): array
    {
        return [
            ['label' => 'Total Registered Users', 'value' => '58,432', 'trend' => '+8.4%'],
            ['label' => 'Total Candidates', 'value' => '36,128', 'trend' => '+6.1%'],
            ['label' => 'Total Companies', 'value' => '4,930', 'trend' => '+2.5%'],
            ['label' => 'Active Job Offers', 'value' => '11,280', 'trend' => '+4.3%'],
        ];
    }

    public static function users(): array
    {
        return [
            ['name' => 'Alex Morgan', 'email' => 'alex@jobhunt.test', 'type' => 'Candidate', 'status' => 'Active', 'regDate' => '2026-04-12'],
            ['name' => 'Sofia Chen', 'email' => 'sofia@northstar.test', 'type' => 'Company', 'status' => 'Verified', 'regDate' => '2026-04-18'],
            ['name' => 'Daniel Ruiz', 'email' => 'daniel@jobhunt.test', 'type' => 'Admin', 'status' => 'Active', 'regDate' => '2026-03-22'],
        ];
    }

    public static function categories(): array
    {
        return [
            ['name' => 'Technology', 'count' => 182],
            ['name' => 'Marketing', 'count' => 114],
            ['name' => 'Finance', 'count' => 89],
            ['name' => 'Design', 'count' => 64],
        ];
    }

    public static function skills(): array
    {
        return ['PHP', 'JavaScript', 'Figma', 'SQL', 'Python', 'UX Research', 'AI Screening', 'Project Management'];
    }

    public static function notifications(): array
    {
        return [
            ['title' => 'New application received', 'detail' => 'Northstar Labs viewed your profile and invited you to interview.', 'time' => '2h ago'],
            ['title' => 'AI Resume score updated', 'detail' => 'Your latest CV score improved to 92%.', 'time' => '1d ago'],
        ];
    }
}
