<?php

namespace App\Console\Commands;

use App\Core\Interfaces\DownloaderInterface;
use App\Core\News\Services\NewsService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Lang;

class NewsParserCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parser:rbc_news';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Download news from rbc.ru';

    /** @var DownloaderInterface */
    private $downloader;

    /** @var NewsService */
    private $newsService;

    /**
     * Create a new command instance.
     *
     * @param DownloaderInterface $downloader
     * @param NewsService $newsService
     */
    public function __construct(DownloaderInterface $downloader, NewsService $newsService)
    {
        parent::__construct();

        $this->downloader = $downloader;
        $this->newsService = $newsService;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $rbcLink = env('RBC_LINK', '');
        if (empty($rbcLink)) {
            $this->error("RBC_LINK not found in .env");
            return 1;
        }
        $news = $this->downloader->download($rbcLink);
        $count = $this->newsService->createAllNews($news);

        echo sprintf('%s %s %s с сайта %s%s',
                Lang::choice('Загружен|Загружено|Загружено', $count, [], 'ru'),
                $count,
                Lang::choice('новый пост|новых поста|новых постов', $count, [], 'ru'),
                $rbcLink,
                PHP_EOL
            );
        return 0;
    }
}
