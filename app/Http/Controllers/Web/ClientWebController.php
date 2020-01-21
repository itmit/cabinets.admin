<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Client;
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
        return view('clients.clientsList', [
            'title' => 'Клиенты',
            'clients' => Client::all()->sortByDesc('created_at')
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
                    'phone' => $request->birthday,
                    'email' => $request->email,
                    'password' => Hash::make($request->birthday),
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
}
