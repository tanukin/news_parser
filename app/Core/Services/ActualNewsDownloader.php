<?php

namespace App\Core\News\Services;

use App\Core\Interfaces\DownloaderInterface;
use App\Core\Interfaces\NewsBuilderInterface;
use PHPHtmlParser\Dom;

class ActualNewsDownloader implements DownloaderInterface
{
    const NEWS_BLOCK_ID = '#js_news_feed_banner';
    const NEWS_SUB_BLOCK_CLASS = '.js-news-feed-list';
    const NEWS_ITEM_CLASS = '.news-feed__item';

    const ITEM_TITLE_CLASS = '.news-feed__item__title';
    const ITEM_DATE_CATEGORY_CLASS = '.news-feed__item__date-text';

    /** @var Dom */
    private $htmlDom;

    /** @var NewsDownloader */
    private $newsDownloader;

    /** @var NewsBuilderInterface */
    private $newsBuilder;

    public function __construct(Dom $htmlDom, NewsDownloader $newsDownloader, NewsBuilderInterface $newsBuilder)
    {
        $this->htmlDom = $htmlDom;
        $this->newsDownloader = $newsDownloader;
        $this->newsBuilder = $newsBuilder;
    }

    /**
     * @inheritDoc
     */
    public function download(string $link): array
    {
        $this->htmlDom->loadFromUrl($link);
        $contents = $this->htmlDom->find(self::NEWS_BLOCK_ID . ' ' .  self::NEWS_SUB_BLOCK_CLASS);
        $newsBlock = $contents->find(self::NEWS_ITEM_CLASS);

        $news = [];
        foreach ($newsBlock as $item) {
            $this->newsBuilder->setTitle($item->find(self::ITEM_TITLE_CLASS)->text);
            $this->newsBuilder->setPublishDateAt($item->getAttribute('data-modif'));

            $documentCategory = $item->find(self::ITEM_DATE_CATEGORY_CLASS)->text;
            $category = substr($documentCategory, 0, strpos($documentCategory, ','));
            $this->newsBuilder->setCategory($category);

            $sourceLink = $item->getAttribute('href');
            $this->newsBuilder->setSourceLink($sourceLink);

            $fullNews = $this->newsDownloader->download($sourceLink);
            if (empty($fullNews)) {
                continue;
            }
            $fullNews = array_shift($fullNews);

            $this->newsBuilder->setSubtitle($fullNews->subtitle);
            $this->newsBuilder->setText($fullNews->text);
            $this->newsBuilder->setPicture($fullNews->picture);

            $news[] = $this->newsBuilder->getNews();
        }

        return $news;
    }
}
