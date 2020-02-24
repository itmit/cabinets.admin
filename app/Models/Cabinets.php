<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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

    public function cabinetPreviewPhoto()
    {
        return $this->hasOne(PhotosToCabinet::class, 'cabinet_id')->first();
    }

    public function getReservations($date)
    {
        return $this->hasMane(CabinetReservation::class, 'cabinet_id')->where('date', $date)->get();
    }
}
