<?php

namespace App\Http\Controllers\Api;

use App\Models\Client;
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
use App\Http\Controllers\Controller;

class UserController extends ApiBaseController
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

    public function updateDeviceToken(Request $request)
    {
        $validator = Validator::make($request->all(), [ 
            'device_token' => 'required',
        ]);
        
        if ($validator->fails()) { 
            return response()->json(['errors'=>$validator->errors()], 401);            
        }

        Client::where('id', auth('api')->user()->id)->update(['device_token' => $request->device_token]);
    }

    public function test(Request $request)
    {
        $url = 'https://fcm.googleapis.com/fcm/send';

        $date = date("Y-m-d", strtotime('+1 day'));
        $reservations = CabinetReservation::where('date', $date)->get();
        $client_token = [];
        foreach ($reservations as $reservation) {
            $client = $reservation->getClient();
            $client_token[$client->id] = $client->device_token;
        }
        
        foreach ($client_token as $key => $value) {
            $fields = array (
                'to' => $value,
                "notification" => [
                    "body" => "У вас забронирован кабинет на завтра",
                    "title" => "Психологическая студия"
                ]
            );
            $fields = json_encode ( $fields );
    
            $headers = array (
                    'Authorization: key=' . env('FIREBASE_KEY'),
                    'Content-Type: application/json'
            );
    
            $ch = curl_init ();
            curl_setopt ( $ch, CURLOPT_URL, $url );
            curl_setopt ( $ch, CURLOPT_POST, true );
            curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
            curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
            curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );
    
            curl_exec ( $ch );
    
            curl_close ( $ch );
        }
    }
}
