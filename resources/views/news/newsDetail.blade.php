<div class="row">
    <div class="col-md-4">
        <div class="thumbnail">
        <a href="/w3images/lights.jpg">
            <img src="/w3images/lights.jpg" alt="Lights" style="width:100%">
            <div class="caption">
            <p>Lorem ipsum...</p>
            </div>
        </a>
        </div>
    </div>
    <div class="col-md-4">
        <div class="thumbnail">
        <a href="/w3images/nature.jpg">
            <img src="/w3images/nature.jpg" alt="Nature" style="width:100%">
            <div class="caption">
            <p>Lorem ipsum...</p>
            </div>
        </a>
        </div>
    </div>
    <div class="col-md-4">
        <div class="thumbnail">
        <a href="/w3images/fjords.jpg">
            <img src="/w3images/fjords.jpg" alt="Fjords" style="width:100%">
            <div class="caption">
            <p>Lorem ipsum...</p>
            </div>
        </a>
        </div>
    </div>
</div>

@extends('layouts.adminApp')

@section('content')

<div class="col-sm-12 tabs-content">
    <div class="row justify-content-center cont-m">
        <div class="col-md-12">
            <h2>{{ $title }}</h2>

            <img src="{{ $preview }}"style="width:100%">

            <p>
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