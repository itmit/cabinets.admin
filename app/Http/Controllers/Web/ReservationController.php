<?php

namespace App\Http\Controllers\Web;

use App\Models\Client;
use App\Models\Cabinets;
use App\Models\CabinetReservation;
use App\Models\CabinetReservationTime;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Spatie\GoogleCalendar\Event;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('reservations.reservationCreate', [
            'title' => 'Добавить бронирование',
            'cabinets' => Cabinets::get(),
            'clients' => Client::get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [ 
            'cabinet' => 'required',
            'client' => 'required',
            'date' => 'required|date',
            'times' => 'required|array'
        ]);
        
        if ($validator->fails()) {
            return redirect()
                ->route('auth.reservations.create')
                ->withErrors($validator)
                ->withInput();
        }

        dd($request);

        $cabinet = Cabinets::where('id', '=', $request->cabinet)->first();

        // if(!$cabinet)
        // {
        //     return response()->json(['error'=>'Нет такого кабинета'], 500);     
        // }

        $reservations = CabinetReservation::where('cabinet_id', '=', $cabinet->id)
        ->where('date', '=', $request->date)->get();
        $authClientId = $request->client;
        $client = Client::where('id', $authClientId)->first();
        $exist = false;
        $resId = 0;
        $resAmount = 0;
        // asort($request->times);
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

                        self::setGoogleCalendar($value, $request->date, $cabinet, $client);
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

                        self::setGoogleCalendar($value, $request->date, $cabinet, $client);

                        CabinetReservation::where('id', $resId)->update([
                            'total_amount' => $amount
                        ]);
                    }
                });
            } catch (\Throwable $th) {
                return $th;
            }
        }
        return redirect()->route('auth.reservations.create');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getTimes(Request $request)
    {
        $validator = Validator::make($request->all(), [ 
            'cabinet' => 'required',
            'date' => 'required|date'
        ]);
        
        if ($validator->fails()) { 
            return response()->json(['errors'=>$validator->errors()], 500);            
        }

        $cabinet = Cabinets::where('id', '=', $request->cabinet)->first();

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

        return response()->json($result);
        // return $this->sendResponse($result, 'Свободное время для выбранного кабинета');
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
