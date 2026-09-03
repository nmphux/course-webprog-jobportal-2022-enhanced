<?php

namespace Controllers;

use Core\Controller;
use Models;

class BookmarkController extends Controller
{
    public function index(): void
    {
        $bookmarkModel = $this->container->get(Models\Bookmark::class);
        $userId        = $this->user()['user_id'];

        $bookmarks = $bookmarkModel->getByUser($userId);

        $this->view('candidate/bookmarks', [
            'bookmarks' => $bookmarks,
        ]);
    }

    public function toggle(array $params): void
    {
        $bookmarkModel = $this->container->get(Models\Bookmark::class);
        $jobModel      = $this->container->get(Models\Job::class);

        $jobId  = (int) $params['id'];
        $userId = $this->user()['user_id'];

        $job = $jobModel->findById($jobId);
        if (!$job) {
            http_response_code(404);
            $this->view('errors/404');
            return;
        }

        if ($bookmarkModel->exists($userId, $jobId)) {
            $bookmarkModel->removeByJobAndUser($jobId, $userId);
            $this->flash('success', __('candidate.bookmark_removed'));
        } else {
            $bookmarkModel->add($userId, $jobId);
            $this->flash('success', __('candidate.bookmark_added'));
        }

        $jobUrl = '/' . ltrim(job_url($job), '/');
        $this->redirect($jobUrl);
    }

    public function delete(array $params): void
    {
        $bookmarkModel = $this->container->get(Models\Bookmark::class);

        $bookmarkId = (int) $params['id'];
        $userId     = $this->user()['user_id'];

        $bookmarkModel->remove($bookmarkId, $userId);

        $this->flash('success', __('candidate.bookmark_removed'));
        $this->redirect('/bookmarks');
    }
}
