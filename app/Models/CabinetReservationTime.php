<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CabinetReservationTime extends Model
{
    /**
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * @var string
     */
    protected $table = 'cabinet_reservation_times';
}
