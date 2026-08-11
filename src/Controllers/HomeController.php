<?php

namespace Controllers;

use Core\Controller;
use Models;

class HomeController extends Controller
{
    public function index(): void
    {
        $jobModel      = $this->container->get(Models\Job::class);
        $companyModel  = $this->container->get(Models\Company::class);
        $categoryModel = $this->container->get(Models\Category::class);

        $recentJobs        = $jobModel->getRecent(6);
        $featuredCompanies = $companyModel->getFeatured(8);
        $categoryCounts    = $categoryModel->getWithJobCounts();

        // Aggregate stats for the homepage hero section
        $totalJobs       = $this->db->query("SELECT COUNT(*) FROM job_posts WHERE status = 'published'")->fetchColumn();
        $totalCompanies  = $this->db->query("SELECT COUNT(*) FROM companies")->fetchColumn();
        $totalCandidates = $this->db->query("SELECT COUNT(*) FROM users WHERE user_type = 0")->fetchColumn();

        $this->view('home/index', [
            'recentJobs'        => $recentJobs,
            'featuredCompanies' => $featuredCompanies,
            'categoryCounts'    => $categoryCounts,
            'stats'             => [
                'total_jobs'       => (int) $totalJobs,
                'total_companies'  => (int) $totalCompanies,
                'total_candidates' => (int) $totalCandidates,
            ],
        ]);
    }
}
