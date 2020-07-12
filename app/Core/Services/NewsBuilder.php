<?php

namespace App\Core\News\Services;

use App\Core\Interfaces\NewsBuilderInterface;
use App\Core\News\Models\News;

class NewsBuilder implements NewsBuilderInterface
{
    private $news;

    public function __construct()
    {
        $this->create();

    }

    public function create(): NewsBuilderInterface
    {
        $this->news = new News();

        return $this;
    }

    public function setTitle(string $title): NewsBuilderInterface
    {
        $this->news->title = htmlentities($title);

        return $this;
    }

    public function setSubtitle(string $subtitle): NewsBuilderInterface
    {
        $this->news->subtitle = htmlentities($subtitle);

        return $this;
    }

    public function setText(string $text): NewsBuilderInterface
    {
        $this->news->text = htmlentities($text);

        return $this;
    }

    public function setPicture(string $picture): NewsBuilderInterface
    {
        $this->news->picture = $picture;

        return $this;
    }

    public function setCategory(string $category): NewsBuilderInterface
    {
        $this->news->category = $category;

        return $this;
    }

    public function setPublishDateAt(int $publishDateAt): NewsBuilderInterface
    {
        $this->news->publish_date_at = $publishDateAt;

        return $this;
    }

    public function setSourceLink(string $sourceLink): NewsBuilderInterface
    {
        $this->news->source_link = $sourceLink;

        return $this;
    }

    public function getNews(): News
    {
        $news = $this->news;
        $this->create();

        return $news;
    }
}
