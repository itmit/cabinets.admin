<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CabinetReservation extends Model
{
    /**
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * @var string
     */
    protected $table = 'cabinet_reservations';

    public function getCabinet()
    {
        return $this->hasOne(Cabinet::class, 'cabinet_id')->first();
    }
}
