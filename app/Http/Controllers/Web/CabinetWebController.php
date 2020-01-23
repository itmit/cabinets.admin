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

                $cabinet = Cabinets::create([
                    'uuid' => Str::uuid(),
                    'name' => $request->name,
                    'area' => $request->area,
                    'capacity' => $request->capacity,
                    'description' => $request->description,
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

    public function show($id)
    {
        $cabinet = Cabinets::where('id', '=', $id)->first();
        $photos = PhotosToCabinet::where('cabinet_id', '=', $id)->get();
        return view('cabinets.cabinetsEdit', [
            'cabinet' => $cabinet,
            'photos' => $photos
        ]);
    }

    public function edit($id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3|max:191|string',
            'area' => 'required|numeric',
            'capacity' => 'required|numeric',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('auth.cabinets.show')
                ->withErrors($validator)
                ->withInput();
        }

        dd($request->file('photos'));

        try {
            DB::transaction(function () use ($request, $id) {

                $cabinet = Cabinets::where('id', '=', $id)->update([
                    'uuid' => Str::uuid(),
                    'name' => $request->name,
                    'area' => $request->area,
                    'capacity' => $request->capacity,
                    'description' => $request->description,
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
        $cabinet = Cabinets::where('id', '=', $id)->first();
        $photos = PhotosToCabinet::where('cabinet_id', '=', $id)->get();
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
}
