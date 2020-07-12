<?php

namespace App\Core\Interfaces;

use App\Core\News\Models\News;

interface NewsBuilderInterface
{
    public function create(): NewsBuilderInterface;

    public function setTitle(string $title): NewsBuilderInterface;

    public function setSubtitle(string $subtitle): NewsBuilderInterface;

    public function setText(string $text): NewsBuilderInterface;

    public function setPicture(string $picture): NewsBuilderInterface;

    public function setCategory(string $category): NewsBuilderInterface;

    public function setPublishDateAt(int $publishDateAt): NewsBuilderInterface;

    public function setSourceLink(string $sourceLink): NewsBuilderInterface;

    public function getNews(): News;
}
