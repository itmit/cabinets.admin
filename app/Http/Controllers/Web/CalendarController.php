<?php

namespace App\Http\Controllers\Web;

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
use App\Http\Controllers\Controller;

class CalendarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('calendar.calendar', ['title' => 'Каледарь']);
    }

    public function getOneDay(Request $request)
    {
        // $reservations = CabinetReservation::where('date', '=', $request->date)->get();
        // if($reservations == NULL)
        // {
        //     return $this->sendResponse([], 'На выбранный день нет забронированных кабинетов');
        // }

        $cabinets = Cabinets::get();

        return response()->json($cabinets);

        $result = [];

        // $times = self::workingTime();

        // $freeTimes = array_diff($times, $resTime);

        // foreach ($freeTimes as $key => $value) {
        //     $result[] = [
        //         "key" => $key,
        //         "value" => $value
        //     ];
        // }

        foreach ($reservations as $reservation) {
            $resTimes = [];
            $cab = [];
            $cabinet = $reservation->getCabinet();
            $client = $reservation->getClient();
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
                'times' => $resTimes,
                'client' => $client
            ];
        }

        return response()->json($result);
    }

    public function getFewDay(Request $request)
    {
        $reservations = CabinetReservation::whereBetween('date', [$request->first_date, $request->second_date])->get();
        if($reservations == NULL)
        {
            return $this->sendResponse([], 'На выбранный день нет забронированных кабинетов');
        }

        $result = [];

        // $times = self::workingTime();

        // $freeTimes = array_diff($times, $resTime);

        // foreach ($freeTimes as $key => $value) {
        //     $result[] = [
        //         "key" => $key,
        //         "value" => $value
        //     ];
        // }

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

        return response()->json($result);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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

    private function workingTime()
    {
        // первая стоимость
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

        // вторая стоимость
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
