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

        return response()->json($result);
    }

    public function getFewDay()
    {
        
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
}
