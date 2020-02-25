@extends('layouts.adminApp')

@section('content')

<div class="col-sm-12 tabs-content">
    <div class="row justify-content-center cont-m">
        <div class="col-md-12">
        <h2>{{ $title }} {{ $client->name }}</h2>

            <a href="../clients">Назад</a>
            
            <div class="form-group">
                <div class="col-xs-12 col-sm-2">
                <label for="name" class="control-label text-tc">Телефон</label>
                </div>
        
                <div class="col-xs-12 col-sm-10">
                    <p>{{ $client->phone }}</p>
                </div>
            </div>
            
        </div>
    </div>
</div> 

@endsection