<?php

namespace App\Core\News\Services;

use App\Core\News\Models\News;
use App\Core\News\Repositories\NewsRepository;

class NewsService
{
    /** @var NewsRepository */
    private $newsRepository;

    public function __construct(NewsRepository $newsRepository)
    {
        $this->newsRepository = $newsRepository;
    }

    public function createAll(array $news): int
    {
        $inc = 0;
        foreach ($news as $post) {
            if ($this->create($post)) {
                $inc++;
            }
        }

        return $inc;
    }

    public function create(News $post): bool
    {
        if (!$this->newsRepository->hasNews($post)) {
            try {
                $this->newsRepository->save($post);
                return true;
            } catch (\DomainException $e) {

            }
        }

        return false;
    }

    public function getAllNewsAnnouncements()
    {
        $news = $this->newsRepository->getAllNewsAnnouncements();

        return $news;
    }

    public function findPost($id)
    {
        $post = $this->newsRepository->findPost($id);

        return $post;
    }
}
