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

        $jobId  = (int) $params['id'];
        $userId = $this->user()['user_id'];

        if ($bookmarkModel->exists($userId, $jobId)) {
            $bookmarkModel->removeByJobAndUser($jobId, $userId);
            $this->flash('success', __('candidate.bookmark_removed'));
        } else {
            $bookmarkModel->add($userId, $jobId);
            $this->flash('success', __('candidate.bookmark_added'));
        }

        $this->redirect('/jobs/' . $jobId);
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
