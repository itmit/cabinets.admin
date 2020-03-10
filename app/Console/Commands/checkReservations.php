<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\CabinetReservation;

class checkReservations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:checkReservations';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
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
