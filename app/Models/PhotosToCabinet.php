<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PhotosToCabinet extends Model
{
    use SoftDeletes;

    /**
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * @var string
     */
    protected $table = 'photos_to_cabinets';
}
