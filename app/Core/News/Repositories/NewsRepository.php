<?php

namespace App\Core\News\Repositories;

use App\Core\News\Models\News;

class NewsRepository
{
    public function save(News $news): News
    {
        if (!$news->save()) {
            throw new \DomainException('News saving error');
        }

        return $news;
    }

    public function hasNews(News $news): bool
    {
        if (News::where('title', '=', $news->title)->exists()) {
            return true;
        }

        return false;
    }
}
