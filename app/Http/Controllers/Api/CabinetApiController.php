<?php

namespace App\Http\Controllers\Api;

use App\Models\Cabinets;
use App\Models\PhotosToCabinet;
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

class CabinetApiController extends ApiBaseController
{
    public $successStatus = 200;

    public function getListOfCabinets()
    {
        $cabinets = Cabinets::all()->sortByDesc('created_at');
        $list = [];
        foreach ($cabinets as $item) {
            $list['uuid'] = $item->uuid;
            $list['name'] = $item->name;
            $list['capacity'] = $item->capacity;
            $list['area'] = $item->area;
            $list['description'] = $item->description;
            $list['photo'] = $item->cabinetPreviewPhoto()->photo;
        }

        return $this->sendResponse($list, 'Список кабинетов');
    }

    public function getCabinet(Request $request)
    {
        $cabinet = Cabinets::where('uuid', '=', $request->uuid)->first();
        $cabinet['photos'] = PhotosToCabinet::where('cabinet_id', '=', $cabinet->id)->get();

        return $this->sendResponse($cabinet, 'Кабинет');
    }



    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [ 
            'email' => 'required|unique:clients|email|max:191',
            'phone' => 'required|unique:clients|max:18',
            'name' => 'required|max:191|min:2',
            'birthday' => 'required',
            'password' => 'required|confirmed|min:6',
        ]);
        
        if ($validator->fails()) { 
            return response()->json(['errors'=>$validator->errors()], 401);            
        }

        if(Client::where('email', '=', $request->email)->exists())
        {
            return response()->json(['error'=>'Клиент уже зарегистрирован'], 401);     
        }

        $this->name = $request->name;
        $this->email = $request->email;
        $this->phone = $request->phone;
        $this->birthday = $request->birthday;
        $this->password = $request->password;
        $this->device_token = $request->device_token;

        DB::transaction(function () {
            $this->user = Client::create([
                'uuid' => Str::uuid(),
                'name' => $this->name,
                'email' => $this->email,
                'phone' => $this->phone,
                'birthday' => $this->birthday,
                'password' => Hash::make($this->password),
            ]);

            if($this->device_token)
            {
                Client::where('id', '=', $this->user->id)->update([
                    'device_token' => $this->device_token
                ]);
            };

        });

        if(!Client::where('email', '=', $request->email)->exists())
        {
            return response()->json(['error'=>'Не удалось зарегистрировать клиента'], 401);     
        }

        Auth::login($this->user);     

        if (Auth::check()) {
            $tokenResult = $this->user->createToken(config('app.name'));
            $token = $tokenResult->token;
            $token->expires_at = Carbon::now()->addWeeks(1);
            $token->save();

            return $this->sendResponse([
                'access_token' => $tokenResult->accessToken,
                'token_type' => 'Bearer',
                'expires_at' => Carbon::parse(
                    $tokenResult->token->expires_at
                )->toDateTimeString()
            ],
                'Authorization is successful');
        }
        
        return response()->json(['error'=>'Не удалось авторизоваться'], 401);     
    }

    /** 
     * login api 
     * 
     * @return Response 
     */ 
    public function login(Request $request) { 

        $validator = Validator::make($request->all(), [ 
            'phone' => 'required',
            'password' => 'required|min:6',
        ]);
        
        if ($validator->fails()) { 
            return response()->json(['errors'=>$validator->errors()], 401);            
        }

        if(!Client::where('phone', '=', $request->phone)->exists())
        {
            return response()->json(['error'=>'Такого пользователя не существует'], 401); 
        }       

        $client = Client::where('phone', '=', $request->phone)->first();

        if(Hash::check($request->password, $client->password))
        {
            Auth::login($client);
            if (Auth::check()) {
                $tokenResult = $client->createToken(config('app.name'));
                $token = $tokenResult->token;
                $token->expires_at = Carbon::now()->addWeeks(1);
                $token->save();

                if($request->device_token)
                {
                    Client::where('id', '=', $client->id)->update([
                        'device_token' => $request->device_token
                    ]);
                }

                return $this->sendResponse([
                    'access_token' => $tokenResult->accessToken,
                    'token_type' => 'Bearer',
                    'expires_at' => Carbon::parse(
                        $tokenResult->token->expires_at
                    )->toDateTimeString(),
                ],
                    'Authorization is successful');
            }
        }
        else
        {
            return response()->json(['error'=>'Неверный пароль'], 401); 
        }
        return response()->json(['error'=>'Авторизация не удалась'], 401); 
    }

    public function logout(Request $request)
    {
        $isUser = $request->client()->token()->revoke();
        if($isUser){
            $success['message'] = "Successfully logged out.";
            return $this->sendResponse($success);
        }
        else{
            $error = "Something went wrong.";
            return $this->sendResponse($error);
        }
    }
    
}
