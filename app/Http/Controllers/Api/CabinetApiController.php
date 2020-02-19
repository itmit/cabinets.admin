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
            $list[] = [
                'uuid' => $item->uuid,
                'name' => $item->name,
                'capacity' => $item->capacity,
                'area' => $item->area,
                'description' => $item->description,
                'price' => $item->price,
                'photo' => $item->cabinetPreviewPhoto()->photo
            ];
        }

        return $this->sendResponse($list, 'Список кабинетов');
    }

    public function getCabinet(Request $request)
    {
        $validator = Validator::make($request->all(), [ 
            'uuid' => 'required|uuid',
        ]);
        
        if ($validator->fails()) { 
            return response()->json(['errors'=>$validator->errors()], 401);            
        }

        $cabinet = Cabinets::where('uuid', '=', $request->uuid)->first()->toArray();
        if(!$cabinet)
        {
            return response()->json(['error'=>'Нет такого кабинета'], 401);     
        }
        $cabinet['photos'] = PhotosToCabinet::where('cabinet_id', '=', $cabinet['id'])->get('photo');

        return $this->sendResponse($cabinet, 'Кабинет');
    }

}
