<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\PictureToNews;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class NewsWebController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('news.newsList', [
            'title' => 'Новости',
            'news' => News::all()->sortByDesc('created_at')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('news.newsCreate', [
            'title' => 'Добавить новость'
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

        $request->news_head = trim($request->news_head);
        $request->news_body = trim($request->news_body);

        $validator = Validator::make($request->all(), [
            'news_head' => 'required|min:3|max:100|string',
            'news_body' => 'required|min:3|max:20000',
            'news_picture_preview' => 'required|image|mimes:jpeg,png,jpg,gif,svg'
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('auth.news.create')
                ->withErrors($validator)
                ->withInput();
        }

        $path = $request->file('news_picture_preview')->store('public/newsPicturePreview');
        $url = Storage::url($path);

        $news = News::create([
            'uuid' => Str::uuid(),
            'head' => $request->input('news_head'),
            'body' => $request->input('news_body'),
            'preview_picture' => $url,
        ]);

        foreach($request->file('news_picture') as $file)
        {
            $path = $file->storeAs('public/newsPictures', $file->getClientOriginalName());
            $url = Storage::url($path);

            PictureToNews::create([
                'news_id' => $news->id,
                'picture' => $url,
            ]);
        }

        return redirect()->route('auth.news.index');
    }

    public function show($id)
    {
        $news = News::where('id', '=', $id)->first();
        $pictures = PictureToNews::where('news_id', '=', $id)->get();
        return view('news.newsDetail', [
            'title' => $news->head,
            'body' => $news->body,
            'preview' => $news->preview_picture,
            'pics' => $pictures
        ]);
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
