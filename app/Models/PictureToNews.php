<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PictureToNews extends Model
{
    /**
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * @var string
     */
    protected $table = 'picture_to_news';
}
