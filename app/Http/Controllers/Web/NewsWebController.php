<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\News;
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
            'news_picture' => 'required|image|mimes:jpeg,png,jpg,gif,svg'
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('auth.news.create')
                ->withErrors($validator)
                ->withInput();
        }

        // return $request->news_body . ' ' . $request->news_head;

        $path = $request->file('news_picture')->store('public/newsPictures');
        $url = Storage::url($path);

        News::create([
            'uuid' => Str::uuid(),
            'head' => $request->input('news_head'),
            'body' => $request->input('news_body'),
            'picture' => $url,
        ]);

        return redirect()->route('auth.news.index');
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
