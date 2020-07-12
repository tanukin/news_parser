<?php

namespace App\Core\News\Services;

use App\Core\Interfaces\DownloaderInterface;
use App\Core\Interfaces\NewsBuilderInterface;
use PHPHtmlParser\Dom;

class NewsDownloader implements DownloaderInterface
{
    const NEWS_BLOCK_CLASS = '.article__text';
    const NEWS_SUB_TITLE_CLASS = '.article__text__overview';
    const NEWS_PICTURE_CLASS = '.article__main-image';


    /** @var Dom */
    private $htmlDom;

    /** @var NewsBuilderInterface */
    private $newsBuilder;

    public function __construct(Dom $htmlDom, NewsBuilderInterface $newsBuilder)
    {
        $this->htmlDom = $htmlDom;
        $this->newsBuilder = $newsBuilder;
    }

    /**
     * @inheritDoc
     */
    public function download(string $link): array
    {
        $this->htmlDom->loadFromUrl($link);
        $content = $this->htmlDom->find( self::NEWS_BLOCK_CLASS);
        if ($content->count() == 0) {
            return [];
        }

        $this->readSubTitle($content);
        $this->readPicture($content);
        $this->readBody($content);

        return [$this->newsBuilder->getNews()];
    }

    protected function readSubTitle(Dom\Collection $content): void
    {
        $subTitle = $content->find(self::NEWS_SUB_TITLE_CLASS);
        if ($subTitle->count() === 0) {
            $this->newsBuilder->setSubtitle('');
            return;
        }

        $this->newsBuilder->setSubtitle($subTitle->find('span')->text);
    }

    protected function readPicture(Dom\Collection $content): void
    {
        $pictureBlock = $content->find(self::NEWS_PICTURE_CLASS);
        if ($pictureBlock->count() === 0) {
            $this->newsBuilder->setPicture('');
            return;
        }

        $img = $pictureBlock->find('img');
        $this->newsBuilder->setPicture($img->getAttribute('src'));
    }

    protected function readBody(Dom\Collection $content): void
    {
        $paragraphs = $content->find('p');
        if ($paragraphs->count() === 0) {
            $this->newsBuilder->setText('');
            return;
        }

        $text = '';
        foreach ($paragraphs as $paragraph) {
            $text = sprintf('%s %s', $text, html_entity_decode($paragraph->text));
        }

        $this->newsBuilder->setText(trim($text));
    }
}
