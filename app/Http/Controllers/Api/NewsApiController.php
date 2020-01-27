<?php

namespace App\Http\Controllers\Api;

use App\Models\News;
use App\Models\PictureToNews;
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

class NewsApiController extends ApiBaseController
{
    public $successStatus = 200;

    public function getNewsList()
    {
        $news = News::all()->sortByDesc('created_at');

        $list = [];
        foreach ($news as $item) {
            $list['uuid'] = $item->uuid;
            $list['head'] = $item->name;
            $list['body'] = $item->capacity;
            $list['preview_picture'] = $item->area;
        }

        return $this->sendResponse($list, 'Список новостей');
    }

    public function getNews(Request $request)
    {
        $validator = Validator::make($request->all(), [ 
            'uuid' => 'required|uuid',
        ]);
        
        if ($validator->fails()) { 
            return response()->json(['errors'=>$validator->errors()], 401);            
        }

        $news = News::where('uuid', '=', $request->uuid)->first()->toArray();
        if(!$news)
        {
            return response()->json(['error'=>'Нет такой новости'], 401);     
        }
        $news['photos'] = PictureToNews::where('news_id', '=', $news['id'])->get('picture');

        return $this->sendResponse($cabinet, 'Кабинет');
    }

}
