<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Cabinets;
use App\Models\PhotosToCabinet;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class CabinetWebController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('cabinets.cabinetsList', [
            'title' => 'Кабинеты',
            'cabinets' => Cabinets::all()->sortByDesc('created_at')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cabinets.cabinetsCreate', [
            'title' => 'Добавить кабинет'
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
            'area' => 'required|numeric',
            'capacity' => 'required|numeric',
            'description' => 'required',
            'price_morning' => 'required|numeric',
            'price_evening' => 'required|numeric',
            'color' => 'required',
            'photos' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('auth.cabinets.create')
                ->withErrors($validator)
                ->withInput();
        }

        try {
            DB::transaction(function () use ($request) {

                $color_html = self::setColor($request->color);

                $cabinet = Cabinets::create([
                    'uuid' => Str::uuid(),
                    'name' => $request->name,
                    'area' => $request->area,
                    'capacity' => $request->capacity,
                    'description' => $request->description,
                    'price_morning' => $request->price_morning,
                    'price_evening' => $request->price_evening,
                    'color' => $request->color,
                    'color_html' => $color_html
                ]);

                foreach($request->file('photos') as $file)
                {
                    $path = $file->store('public/cabinets');
                    $url = Storage::url($path);

                    PhotosToCabinet::create([
                        'cabinet_id' => $cabinet->id,
                        'photo' => $url,
                    ]);
                }
    
            });
        } catch (\Throwable $th) {
            return $th;
        }

        return redirect()->route('auth.cabinets.index');
    }

    public function edit($id)
    {
        $cabinet = Cabinets::where('id', '=', $id)->first();
        $photos = PhotosToCabinet::where('cabinet_id', '=', $id)->get();
        return view('cabinets.cabinetsEdit', [
            'cabinet' => $cabinet,
            'photos' => $photos,
            'id' => $id
        ]);
    }

    public function update($id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3|max:191|string',
            'area' => 'required|numeric',
            'capacity' => 'required|numeric',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('auth.cabinets.edit', ['id' => $id])
                ->withErrors($validator)
                ->withInput();
        }

        try {
            DB::transaction(function () use ($request, $id) {

                $color_html = self::setColor($request->color);

                $cabinet = Cabinets::where('id', $id)->update([
                    'name' => $request->name,
                    'area' => $request->area,
                    'capacity' => $request->capacity,
                    'description' => $request->description,
                    'price_morning' => $request->price_morning,
                    'price_evening' => $request->price_evening,
                    'color' => $request->color,
                    'color_html' => $color_html,
                ]);

                if ($request->hasFile('photos')) {
                    foreach($request->file('photos') as $file)
                    {
                        $path = $file->store('public/cabinets');
                        $url = Storage::url($path);

                        PhotosToCabinet::create([
                            'cabinet_id' => $cabinet->id,
                            'photo' => $url,
                        ]);
                    }
                }

            });
        } catch (\Throwable $th) {
            return $th;
        }
        // $cabinet = Cabinets::where('id', '=', $id)->first();
        // $photos = PhotosToCabinet::where('cabinet_id', '=', $id)->get();
        return redirect()->route('auth.cabinets.index');    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        // News::where('id', '=', $request->id)->delete();
        // return response()->json(['succses'=>'Удалено'], 200); 
    }

    public function deletePhoto(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'photo' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Validation error'], 500);
        }

        PhotosToCabinet::where('id', $request->photo)->delete();
        
        return response()->json(['Deleted'], 200);
    }

    public function setColor($color)
    {
        switch ($color) {
            case 1:
                $color_html = 'blue';
                break;
            case 2:
                $color_html = 'green';
                break;
            case 3:
                $color_html = 'purple';
                break;
            case 4:
                $color_html = 'red';
                break;
            case 5:
                $color_html = 'yellow';
                break;
            case 6:
                $color_html = 'orange';
                break;
            case 7:
                $color_html = 'turquoise';
                break;
            case 8:
                $color_html = 'gray';
                break;
            case 9:
                $color_html = 'bold blue';
                break;
            case 10:
                $color_html = 'bold green';
                break;
            case 11:
                $color_html = 'bold red';
                break;

            default:
                $color_html = 'blue';
                break;
        }

        return $color_html;
    }
}
