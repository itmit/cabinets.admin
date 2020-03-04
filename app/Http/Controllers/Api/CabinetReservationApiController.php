<?php

namespace App\Http\Controllers\Api;

use App\Models\Client;
use App\Models\Cabinets;
use App\Models\CabinetReservation;
use App\Models\CabinetReservationTime;
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
use Spatie\GoogleCalendar\Event;

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
            return response()->json(['errors'=>$validator->errors()], 500);            
        }

        $cabinet = Cabinets::where('uuid', '=', $request->uuid)->first();

        if(!$cabinet)
        {
            return response()->json(['error'=>'Нет такого кабинета'], 500);     
        }

        $reservations = CabinetReservation::where('cabinet_id', '=', $cabinet->id)->where('date', '=', $request->date)->get();

        $resTime = [];
        foreach ($reservations as $key => $value) {
            $times = CabinetReservationTime::where('reservation_id', '=', $value->id)->get();
            foreach ($times as $item) {
                $resTime[] = $item->time;
            }
        }

        $result = [];

        $times = self::workingTime();

        $freeTimes = array_diff($times, $resTime);

        foreach ($freeTimes as $key => $value) {
            $result[] = [
                "key" => $key,
                "value" => $value
            ];
        };

        if($request->date == date('Y-m-d'))
        {
            $times = self::unsetExpTime($result);

            $result = [];
            foreach ($times as $key => $value) {
                $result[] = $value;
            };
        }

        if($request->date < date('Y-m-d'))
        {
            $result = [];
        }
        

        // return $this->sendResponse([$expire], 'test');

        return $this->sendResponse($result, 'Свободное время для выбранного кабинета');
    }

    public function makeReservation(Request $request)
    {
        $validator = Validator::make($request->all(), [ 
            'uuid' => 'required|uuid',
            'date' => 'required|date',
            'times' => 'required|array'
        ]);
        
        if ($validator->fails()) { 
            return response()->json(['errors'=>$validator->errors()], 500);            
        }

        $cabinet = Cabinets::where('uuid', '=', $request->uuid)->first();

        if(!$cabinet)
        {
            return response()->json(['error'=>'Нет такого кабинета'], 500);     
        }

        $reservations = CabinetReservation::where('cabinet_id', '=', $cabinet->id)
        ->where('date', '=', $request->date)->get();
        $authClientId = auth('api')->user()->id;
        $client = Client::where('id', $authClientId)->first();
        $exist = false;
        $resId = 0;
        $resAmount = 0;
        foreach ($reservations as $key => $value) {
            if($value->cabinet_id == $cabinet->id AND $value->client_id == $authClientId AND $value->date == $request->date)
            {
                $exist = true;
                $resId = $value->id;
                $resAmount = $value->total_amount;
            };
            foreach ($request->times as $key2 => $time)
            {
                if(CabinetReservationTime::where('reservation_id', '=', $value->id)
                ->where('time', '=', $time)
                ->exists()) return response()->json(['error'=>'Кабинет на это время уже забронирован'], 500);
            }
        }
        if($exist)
        {
            try {
                DB::transaction(function () use ($request, $resId, $resAmount, $cabinet, $client) {
                    foreach ($request->times as $key => $value)
                    {
                        if($key <= 18)
                        {
                            $price = $cabinet->price_morning;
                        }
                        if($key > 18)
                        {
                            $price = $cabinet->price_evening;
                        }

                        $resAmount = $resAmount + intdiv($price, 2);

                        CabinetReservationTime::create([
                            'uuid' => Str::uuid(),
                            'reservation_id' => $resId,
                            'time' => $value,
                            'price' => intdiv($price, 2)
                        ]);

                        $event = new Event;

                        $startEndTime = explode('-', $value);

                        $startDateTime = new Carbon('' . $request->date . ' ' . $startEndTime[0] . ':00');
                        $endDateTime = new Carbon('' . $request->date . ' ' . $startEndTime[1] . ':00');

                        $event->name = $cabinet->name . ' забронировал ' . $client->name;
                        $event->startDateTime = $startDateTime;
                        $event->endDateTime = $endDateTime;

                        $event->save();
                    }
                    CabinetReservation::where('id', $resId)->update([
                        'total_amount' => $resAmount
                    ]);
                });
            } catch (\Throwable $th) {
                return $th;
            }
        }
        else
        {
            try {
                DB::transaction(function () use ($request, $cabinet, $authClientId, $client) {
                    $amount = 0;
                    $resId = CabinetReservation::create([
                        'uuid' => Str::uuid(),
                        'cabinet_id' => $cabinet->id,
                        'client_id' => $authClientId,
                        'date' => $request->date,
                    ]);

                    $resId = $resId->id;

                    foreach ($request->times as $key => $value)
                    {
                        if($key <= 18)
                        {
                            $price = $cabinet->price_morning;
                        }
                        if($key > 18)
                        {
                            $price = $cabinet->price_evening;
                        }

                        $amount = $amount + intdiv($price, 2);

                        CabinetReservationTime::create([
                            'uuid' => Str::uuid(),
                            'reservation_id' => $resId,
                            'time' => $value,
                            'price' => intdiv($price, 2)
                        ]);

                        $event = new Event;

                        $startEndTime = explode('-', $value);

                        $startDateTime = new Carbon('' . $request->date . ' ' . $startEndTime[0] . ':00');
                        $startDateTime->setTimezone('Europe/Moscow');
                        $endDateTime = new Carbon('' . $request->date . ' ' . $startEndTime[1] . ':00');
                        $endDateTime->setTimezone('Europe/Moscow');

                        $event->name = $cabinet->name . ' забронировал ' . $client->name;
                        $event->startDateTime = $startDateTime;
                        $event->endDateTime = $endDateTime;
                        $event->colorId = 4;

                        $event->save();

                        CabinetReservation::where('id', $resId)->update([
                            'total_amount' => $amount
                        ]);
                    }
                });
            } catch (\Throwable $th) {
                return $th;
            }
        }
        return $this->sendResponse([], 'Кабинет забронирован');
    }

    public function getUsersReservations()
    {
        $userReservations = CabinetReservation::where('client_id', '=', auth('api')->user()->id)->get();

        $result = [];
        foreach ($userReservations as $key => $value) {
            $result[] = [
                'uuid' => $value->uuid,
                'date' => $value->date,
                'cabinet' => Cabinets::where('id', '=', $value->cabinet_id)->first('name')
            ];
        }
        return $this->sendResponse($result, 'Список бронирований');
    }

    public function getUsersReservationDetail(Request $request)
    {
        $validator = Validator::make($request->all(), [ 
            'uuid' => 'required|uuid'
        ]);
        
        if ($validator->fails()) { 
            return response()->json(['errors'=>$validator->errors()], 500);            
        }

        $reservation = CabinetReservation::where('uuid', '=', $request->uuid)->first();
        $resDetail['cabinet'] = Cabinets::where('id', '=', $reservation->cabinet_id)->first();
        $times = CabinetReservationTime::where('reservation_id', '=', $reservation->id)->get();
        foreach ($times as $key => $value) {
            $resDetail['times'][] = $value->time;
        }
        $resDetail['amount'] = $reservation->total_amount;
        $resDetail['is_paid'] = $reservation->is_paid;
        return $this->sendResponse($resDetail, 'Информация о бронировании');
    }

    public function cancelReservation(Request $request)
    {
        $validator = Validator::make($request->all(), [ 
            'uuid' => 'required|uuid'
        ]);
        
        if ($validator->fails()) { 
            return response()->json(['errors'=>$validator->errors()], 500);            
        }

        $reservation = CabinetReservation::where('uuid', '=', $request->uuid)->first();
        if($reservation == NULL)
        {
            return response()->json(['error'=>'нет такого бронирования'], 500);        
        }

        try {
            DB::transaction(function () use ($reservation, $request) {
                CabinetReservationTime::where('reservation_id', $reservation->id)->delete();
                CabinetReservation::where('uuid', '=', $request->uuid)->delete();
            });
        } catch (\Throwable $th) {
            return $th;
        }

        return $this->sendResponse([], 'Бронирование удалено');
    }

    public function updateReservation(Request $request)
    {
        $validator = Validator::make($request->all(), [ 
            'uuid_cabinet' => 'required|uuid|exists:cabinets,uuid',
            'uuid_reservation' => 'required|uuid|exists:cabinet_reservations,uuid',
            'date' => 'required|date',
            'times' => 'required|array'
        ]);

        if ($validator->fails()) { 
            return response()->json(['errors'=>$validator->errors()], 500);            
        }

        $cabinet = Cabinets::where('uuid', '=', $request->uuid_cabinet)->first();

        $reservation = CabinetReservation::where('uuid', '=', $request->uuid_reservation)->first();
        if($reservation == NULL)
        {
            return response()->json(['error'=>'нет такого бронирования'], 500);        
        }

        $authClientId = auth('api')->user()->id;
        $amount = 0;
        try {
            DB::transaction(function () use ($request, $reservation, $cabinet) {
                CabinetReservationTime::where('reservation_id', $reservation->id)->delete();
                $amount = 0;
                foreach ($request->times as $key => $value)
                {
                    if($key <= 18)
                    {
                        $price = $cabinet->price_morning;
                    }
                    if($key > 18)
                    {
                        $price = $cabinet->price_evening;
                    }

                    $amount = $amount + intdiv($price, 2);

                    CabinetReservationTime::create([
                        'uuid' => Str::uuid(),
                        'reservation_id' => $reservation->id,
                        'time' => $value,
                        'price' => intdiv($price, 2)
                    ]);

                    CabinetReservation::where('id', $reservation->id)->update([
                        'date' => $request->date,
                        'total_amount' => $amount
                    ]);
                }
            });
        } catch (\Throwable $th) {
            return $th;
        }

        return $this->sendResponse([], 'Бронирование обновлено');
    }

    public function getBusyCabinetsByDate(Request $request)
    {
        $validator = Validator::make($request->all(), [ 
            'date' => 'required|date',
        ]);

        if ($validator->fails()) { 
            return response()->json(['errors'=>$validator->errors()], 500);            
        }

        $reservations = CabinetReservation::where('date', '=', $request->date)->get();
        if($reservations == NULL)
        {
            return $this->sendResponse([], 'На выбранный день нет забронированных кабинетов');
        }

        $result = [];

        foreach ($reservations as $reservation) {
            $resTimes = [];
            $cab = [];
            $cabinet = $reservation->getCabinet();
            $cab = [
                'uuid' => $cabinet->uuid,
                'name' => $cabinet->name   
            ];
            $times = CabinetReservationTime::where('reservation_id', $reservation->id)->get();
            foreach ($times as $time) {
                $resTimes[] = $time->time;
            }
            $result[] = [
                'cabinet' => $cab,
                'times' => $resTimes
            ];
        }

        return $this->sendResponse($result, 'Забронированные кабинеты');
    }

    public function getAmount()
    {
        $authClientId = auth('api')->user()->id;
        $amount = 0;
        $reservations = CabinetReservation::where('client_id', $authClientId)->where('is_paid', 0)->get();
        foreach ($reservations as $item) {
           $amount = $amount + $item->total_amount;
        }

        return $this->sendResponse(['amount' => $amount], 'Сумма к оплате');
    }

    private function workingTime()
    {
        // первая стоимость
        $time[0] = '7:00-7:30'; 
        $time[1] = '7:30-8:00';
        $time[2] = '8:00-8:30';
        $time[3] = '8:30-9:00';
        $time[4] = '9:00-9:30';
        $time[5] = '9:30-10:00';
        $time[6] = '10:00-10:30';
        $time[7] = '10:30-11:00';
        $time[8] = '11:00-11:30';
        $time[9] = '11:30-12:00';
        $time[10] = '12:00-12:30';
        $time[11] = '12:30-13:00';
        $time[12] = '13:00-13:30';
        $time[13] = '13:30-14:00';
        $time[14] = '14:00-14:30';
        $time[15] = '14:30-15:00';
        $time[16] = '15:00-15:30';
        $time[17] = '15:30-16:00';
        $time[18] = '16:00-16:30';

        // вторая стоимость
        $time[19] = '16:30-17:00'; 
        $time[20] = '17:00-17:30';
        $time[21] = '17:30-18:00';
        $time[22] = '18:00-18:30';
        $time[23] = '18:30-19:00';
        $time[24] = '19:00-19:30';
        $time[25] = '19:30-20:00';
        $time[26] = '20:00-20:30';
        $time[27] = '20:30-21:00';
        $time[28] = '21:00-21:30';
        $time[29] = '21:30-22:00';
        $time[30] = '22:00-22:30';
        $time[31] = '22:30-23:00';

        return $time;
    }

    private function unsetExpTime($result)
    {
        $expire = idate('H', strtotime('+ 4 hour'));
        
        switch ($expire) {
            case 8:
                for($i = 0; $i < 4; $i++) unset($result[$i]);
                break;

            case 9:
                for($i = 0; $i < 6; $i++) unset($result[$i]);
                break;

            case 10:
                for($i = 0; $i < 8; $i++) unset($result[$i]);
                break;

            case 11:
                for($i = 0; $i < 10; $i++) unset($result[$i]);
                break;
                
            case 12:
                for($i = 0; $i < 12; $i++) unset($result[$i]);
                break;

            case 13:
                for($i = 0; $i < 13; $i++) unset($result[$i]);
                break;

            case 14:
                for($i = 0; $i < 15; $i++) unset($result[$i]);
                break;

            case 15:
                for($i = 0; $i < 17; $i++) unset($result[$i]);
                break;

            case 16:
                for($i = 0; $i < 19; $i++) unset($result[$i]);
                break;

            case 17:
                for($i = 0; $i < 21; $i++) unset($result[$i]);
                break;

            case 18:
                for($i = 0; $i < 23; $i++) unset($result[$i]);
                break;

            case 19:
                for($i = 0; $i < 25; $i++) unset($result[$i]);
                break;
                
            case 20:
                for($i = 0; $i < 27; $i++) unset($result[$i]);
                break;

            case 21:
                for($i = 0; $i < 29; $i++) unset($result[$i]);
                break;

            case 22:
                for($i = 0; $i < 30; $i++) unset($result[$i]);
                break;

            case 23:
                for($i = 0; $i < 30; $i++) unset($result[$i]);
                break;
            
            default:
                # code..
                break;
        }

        return $result;

    }
}
