<?php

namespace App\Core\News\Services;

use App\Core\Interfaces\DownloaderInterface;
use App\Core\Interfaces\NewsBuilderInterface;
use App\Core\News\Models\News;
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

    /** @var ImageUploader */
    private $imageUploader;

    public function __construct(Dom $htmlDom, NewsBuilderInterface $newsBuilder, ImageUploader $imageUploader)
    {
        $this->htmlDom = $htmlDom;
        $this->newsBuilder = $newsBuilder;
        $this->imageUploader = $imageUploader;
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

        $subtitle = $pictureLink = $text = null;
        foreach ($content as $key => $item) {
            if ($key < 1) {
                $subtitle = $this->readSubTitle($item);
                $pictureLink = $this->readPicture($item);
            }
            $text = sprintf("%s %s", $text, $this->readBody($item));
        }

        $this->newsBuilder->setSubtitle($subtitle);
        $this->newsBuilder->setPicture($pictureLink);
        $this->newsBuilder->setText(trim($text));

        $news = $this->newsBuilder->getNews();

        return [$news];
    }

    protected function readSubTitle(Dom\HtmlNode $content): ?string
    {
        $subTitle = $content->find(self::NEWS_SUB_TITLE_CLASS);
        if ($subTitle->count() === 0) {
            return null;
        }

       return $subTitle->find('span')->text;
    }

    protected function readPicture(Dom\HtmlNode $content): ?string
    {
        $pictureBlock = $content->find(self::NEWS_PICTURE_CLASS);
        if ($pictureBlock->count() === 0) {
            return null;
        }

        $img = $pictureBlock->find('img');
        $path = $img->getAttribute('src');

        $ext = pathinfo($path, PATHINFO_EXTENSION);
        $fileName = sprintf("%s.%s", uniqid(), $ext);

        if (!$this->imageUploader->upload($fileName, file_get_contents($path), News::STORAGE)) {
            return null;
        }

        return $fileName;
    }

    protected function readBody(Dom\HtmlNode $content): string
    {
        $paragraphs = $content->find('p');
        if ($paragraphs->count() === 0) {
            $this->newsBuilder->setText('');
            return '';
        }

        $text = '';
        foreach ($paragraphs as $paragraph) {
            $text = sprintf('%s %s', $text, $paragraph->text);
        }

        return trim($text);
    }
}
