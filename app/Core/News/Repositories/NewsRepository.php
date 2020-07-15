<?php

namespace App\Core\News\Repositories;

use App\Core\News\Models\News;
use Illuminate\Support\Collection;

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

    public function getAllNewsAnnouncements(): Collection
    {
        $columns = implode(', ', [
            'id',
            'title',
            'CONCAT(LEFT(CONCAT(IFNULL(subtitle, ""), " ", text), 200), "...") as subtitle'
        ]);

        $model = app(News::class);

        $result = $model
            ->selectRaw($columns)
            ->toBase()
            ->get();

        return $result;
    }

    public function findPost($id): ?News
    {
        $post = News::find($id);

        return $post;
    }
}
