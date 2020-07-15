<?php

namespace App\Http\Controllers\News;

use App\Core\News\Services\NewsService;
use App\Http\Controllers\Controller;

class NewsController extends Controller
{
    /** @var NewsService */
    private $newsService;

    /**
     * AdvertisementController constructor.
     *
     * @param NewsService $newsService
     */
    public function __construct(NewsService $newsService)
    {
        $this->newsService = $newsService;
    }

    public function index()
    {
        $news = $this->newsService->getAllNewsAnnouncements();

        return view('news.main', compact('news'));
    }

    public function show($id)
    {
        $post = $this->newsService->findPost($id);
        if ($post === null) {
            abort(404);
        }

        return view('news.show', compact('post'));
    }
}
