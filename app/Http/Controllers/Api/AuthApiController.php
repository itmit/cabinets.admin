<?php

namespace App\Http\Controllers\Api;

use App\Models\Client;
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

class AuthApiController extends ApiBaseController
{
    public $successStatus = 200;

    private $name;
    private $email;
    private $phone;
    private $password;
    private $user;
    private $birthday;
    private $device_token;

    // |regex:/\+?([0-9]{2})-?([0-9]{3})-?([0-9]{6,7})/

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [ 
            'email' => 'required|unique:clients|email|max:191',
            'phone' => 'required|unique:clients|max:18|min:18',
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
                'client' => $this->user,
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
            // 'phone' => 'required|max:18|min:18',
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
                    'client' => $client,
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

    public function logout()
    {
        if (Auth::check()) {
            Auth::user()->AauthAcessToken()->delete();
        }
        // $user = Auth::user()->token();
        // $user->revoke();
    }

    public function sendCode(Request $request)
    {
        $validator = Validator::make($request->all(), [ 
            'email' => 'required|email|exists:clients',
        ]);
        
        if ($validator->fails()) { 
            return response()->json(['errors'=>$validator->errors()], 401);            
        }

        $code = random_int(1000, 9999);
        $message = "Ваш код для сброса пароля: " . $code;

        Client::where('email', $request->email)->update([
            'code' => $code
        ]);

        // На случай если какая-то строка письма длиннее 70 символов мы используем wordwrap()
        $message = wordwrap($message, 70, "\r\n");

        // Отправляем
        mail($request->email, 'Психологическая студия. Сброс пароля', $message);
    }
    
    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [ 
            'email' => 'required|email|exists:clients',
            'code' => 'required',
            'password' => 'required|confirmed'
        ]);
        
        if ($validator->fails()) { 
            return response()->json(['errors'=>$validator->errors()], 401);            
        }

        $client = Client::where('email', $request->email)->first();

        if($request->code == $client->code)
        {
            $client->update([
                'password' => Hash::make($request->password),
                'code' => null
            ]);
        }
        else return response()->json(['error'=>'Wrong code'], 400);     

        return $this->sendResponse([], 'Пароль успешно сменен');
    }

    public function updateDeviceToken(Request $request)
    {
        $validator = Validator::make($request->all(), [ 
            'device_token' => 'required',
        ]);

        if ($validator->fails()) { 
            return response()->json(['errors'=>$validator->errors()], 401);            
        }

        Client::where('id', auth('api')->user()->id)->update([
            'device_token' => $request->device_token
        ]);

        return $this->sendResponse([], 'Девайс токен обновлен');
    }
    
}
