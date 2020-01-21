<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cabinets extends Model
{
    /**
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * @var string
     */
    protected $table = 'cabinets';
}
