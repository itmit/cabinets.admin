<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\CabinetReservation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class ClientWebController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clients = Client::all()->sortByDesc('created_at');
        $result = [];
        foreach ($clients as $client) {
            $amount = 0;
            $reservations = CabinetReservation::where('client_id', $client->id)->get();
            foreach ($reservations as $item) {
                if($item->is_paid == 0) $amount = $amount + $item->total_amount;
            }
            $result[] = [
                'client' => $client,
                'amount' => $amount
            ];
        }
        
        return view('clients.clientsList', [
            'title' => 'Клиенты',
            'clients' => $result
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('clients.clientsCreate', [
            'title' => 'Добавить клиента'
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
            'name' => 'required|min:3|max:191|string',
            'birthday' => 'required',
            'email' => 'required|unique:clients|email',
            'phone' => 'required|unique:clients|max:18|unique:clients',
            'password' => 'required|confirmed|min:6',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('auth.clients.create')
                ->withErrors($validator)
                ->withInput();
        }

        try {
            DB::transaction(function () use ($request) {

                Client::create([
                    'uuid' => Str::uuid(),
                    'name' => $request->name,
                    'birthday' => $request->birthday,
                    'phone' => $request->phone,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                ]);
    
            });
        } catch (\Throwable $th) {
            return $th;
        }

        return redirect()->route('auth.clients.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        News::where('id', '=', $request->id)->delete();
        return response()->json(['succses'=>'Удалено'], 200); 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $amount = 0;
        $reservations = CabinetReservation::where('client_id', $id)->orderBy('created_at', 'desc')->get();
        foreach ($reservations as $item) {
            if($item->is_paid == 0) $amount = $amount + $item->total_amount;
        }
        return view('clients.clientDetail', [
            'title' => 'Клиент',
            'client' => Client::where('id', $id)->first(),
            'amount' => $amount,
            'reservations' => $reservations
        ]);
    }

    public function paid(Request $request)
    {
        $validator = Validator::make($request->all(), [ 
            'reservation' => 'required|uuid|exists:cabinet_reservations,uuid',
        ]);
        
        if ($validator->fails()) { 
            return response()->json(['errors'=>$validator->errors()], 401);            
        }

        $reservation = CabinetReservation::where('uuid', $request->reservation)->update(['is_paid'=>1]);

        return response()->json();
    }
}
