<?php

namespace Controllers;

use Core\Controller;
use Models;

class SearchController extends Controller
{
    public function suggest(): void
    {
        $q = trim($_GET['q'] ?? '');

        if ($q === '') {
            $this->json([]);
            return;
        }

        $skillModel    = $this->container->get(Models\Skill::class);
        $categoryModel = $this->container->get(Models\Category::class);

        $skills     = $skillModel->suggest($q);
        $categories = $categoryModel->getAll();

        // Filter categories matching the query
        $matchedCategories = array_values(array_filter($categories, function ($cat) use ($q) {
            return stripos($cat['name'], $q) !== false;
        }));

        $results = [
            'skills'     => $skills,
            'categories' => array_map(function ($cat) {
                return ['id' => $cat['id'], 'name' => $cat['name']];
            }, $matchedCategories),
        ];

        $this->json($results);
    }
}
