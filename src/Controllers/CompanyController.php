<?php

namespace Controllers;

use Core\Controller;
use Models;

class CompanyController extends Controller
{
    public function show(array $params): void
    {
        $companyModel = $this->container->get(Models\Company::class);

        $id      = (int) $params['id'];
        $company = $companyModel->findById($id);

        if (!$company) {
            http_response_code(404);
            $this->view('errors/404');
            return;
        }

        $jobs = $companyModel->getJobs($id);

        $this->view('company/show', [
            'company' => $company,
            'jobs'    => $jobs,
        ]);
    }
}
