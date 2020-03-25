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
        $cabinets = Cabinets::all()->sortByDesc('name');
        $list = [];
        foreach ($cabinets as $item) {
            if($item->color_html == 'bold blue') $item->color_html = 'darkblue';
            if($item->color_html == 'bold green') $item->color_html = 'darkgreen';
            if($item->color_html == 'bold red') $item->color_html = 'darkred';
            $list[] = [
                'uuid' => $item->uuid,
                'name' => $item->name,
                'capacity' => $item->capacity,
                'area' => $item->area,
                'description' => $item->description,
                'price' => $item->price,
                'colour' => $item->color_html,
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
