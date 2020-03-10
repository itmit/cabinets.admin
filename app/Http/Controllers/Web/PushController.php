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

class PushController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pushes.push', [
            'title' => 'Уведомления',
            'clients' => Client::get()
        ]);
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

    public function sendPush(Request $request)
    {
        $url = 'https://fcm.googleapis.com/fcm/send';
        if($request->type == 'all')
        {

        }
        if($request->type == 'cli')
        {
            foreach ($request->clients as $client) {
                $token = Client::where('id', $client)->first()->device_token;
                $fields = array (
                    'to' => $user->user()->device_token,
                    "notification" => [
                        "body" => $request->text,
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

    private function sendPushToAll()
    {

    }

    private function sendPushToClients()
    {
        
    }
}
