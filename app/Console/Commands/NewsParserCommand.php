<?php

namespace App\Console\Commands;

use App\Core\Interfaces\DownloaderInterface;
use App\Core\News\Services\NewsService;
use Illuminate\Console\Command;
use Illuminate\Log\Logger;
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

    /** @var Logger */
    private $logger;

    /**
     * Create a new command instance.
     *
     * @param DownloaderInterface $downloader
     * @param NewsService $newsService
     * @param Logger $logger
     */
    public function __construct(DownloaderInterface $downloader, NewsService $newsService, Logger $logger)
    {
        parent::__construct();

        $this->downloader = $downloader;
        $this->newsService = $newsService;
        $this->logger = $logger;
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
        try {
            $news = $this->downloader->download($rbcLink);
            $count = $this->newsService->createAll($news);
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
            echo 'Не удалось загрузить посты. Повторите позже.';
            return 2;
        }

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
