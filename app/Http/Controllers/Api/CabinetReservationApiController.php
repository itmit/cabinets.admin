<?php

namespace App\Http\Controllers\Api;

use App\Models\Cabinets;
use App\Models\CabinetReservation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CabinetReservationApiController extends ApiBaseController
{
    public $successStatus = 200;

    public function checkCabinetByDate(Request $request)
    {
        $validator = Validator::make($request->all(), [ 
            'uuid' => 'required|uuid',
            'date' => 'required|date'
        ]);
        
        if ($validator->fails()) { 
            return response()->json(['errors'=>$validator->errors()], 401);            
        }

        $cabinet = Cabinets::where('uuid', '=', $request->uuid)->first();

        if(!$cabinet)
        {
            return response()->json(['error'=>'Нет такого кабинета'], 401);     
        }

        $reservation = CabinetReservation::where('cabinet_id', '=', $cabinet->id)->where('date', '=', $request->date)->get()->toArray();

        $times = self::workingTime();
        $freeTimes = [];

        foreach($times as $item)
        {
            foreach ($reservation as $free) {
                if($item != $free->time) $freeTimes[] = $time;
            }
        }

        return $this->sendResponse($freeTimes, 'Свободное время для выбранного кабинета');
    }

    private function workingTime()
    {
        $time[0] = '7.00-7.30';
        $time[1] = '7.30-8.00';
        $time[2] = '8.00-8.30';
        $time[3] = '8.30-9.00';
        $time[4] = '9.00-9.30';
        $time[5] = '9.30-10.00';
        $time[6] = '10.00-10.30';
        $time[7] = '10.30-11.00';
        $time[8] = '11.00-11.30';
        $time[9] = '11.30-12.00';
        $time[10] = '12.00-12.30';
        $time[11] = '12.30-13.00';
        $time[12] = '13.00-13.30';
        $time[13] = '13.30-14.00';
        $time[13] = '14.00-14.30';
        $time[14] = '14.30-15.00';
        $time[15] = '15.00-15.30';
        $time[16] = '15.30-16.00';
        $time[17] = '16.00-16.30';
        $time[18] = '16.30-17.00';
        $time[19] = '17.00-17.30';
        $time[20] = '17.30-18.00';
        $time[21] = '18.00-18.30';
        $time[22] = '18.30-19.00';
        $time[23] = '19.00-19.30';
        $time[24] = '19.30-20.00';
        $time[25] = '20.00-20.30';
        $time[26] = '20.30-21.00';
        $time[27] = '21.00-21.30';
        $time[28] = '21.30-22.00';
        $time[29] = '22.00-22.30';
        $time[30] = '22.30-23.00';

        return $time;
    }
}
