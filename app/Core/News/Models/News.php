<?php

namespace App\Core\News\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class News
 *
 * @package App\Core\News\Models
 * @property int $id
 * @property string $title
 * @property string $subtitle
 * @property string $text
 * @property string $picture
 * @property string $category
 * @property int $publish_date_at
 * @property string $source_link
 */
class News extends Model
{
    const STORAGE = 'news';

    public $timestamps = false;

    protected $table = 'news';
}
