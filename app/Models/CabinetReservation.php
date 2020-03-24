<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CabinetReservation extends Model
{
    use SoftDeletes;
    
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
        return $this->belongsTo(Cabinets::class, 'cabinet_id')->first();
    }

    public function getClient()
    {
        return $this->belongsTo(Client::class, 'client_id')->first();
    }

    public function getTimes()
    {
        return $this->hasMany(CabinetReservationTime::class, 'reservation_id')->withTrashed()->get();
    }
}
