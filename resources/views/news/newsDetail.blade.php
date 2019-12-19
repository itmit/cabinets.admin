@extends('layouts.adminApp')

@section('content')

<div class="col-sm-12 tabs-content">
    <div class="row justify-content-center cont-m">
        <div class="col-md-12">
            <h2>{{ $title }}</h2>

            <a href="news/">Назад</a>

            

            <p>
                <img src="{{ $preview }}"style="width:30%"  style="float:left; margin: 7px 7px 7px 0;">
                {{ $body }}
            </p>

            <div class="row">
                @foreach($pics as $item)

                <div class="col-md-4">
                    <div class="thumbnail">
                    <a href="{{ $item->picture }}">
                        <img src="{{ $item->picture }}"style="width:100%">
                    </a>
                    </div>
                </div>
                
                @endforeach
            </div>
        </div>
    </div>
</div> 

@endsection