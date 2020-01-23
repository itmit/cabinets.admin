@extends('layouts.adminApp')

@section('content')

<div class="col-sm-12 tabs-content">
    <div class="row justify-content-center cont-m">
        <div class="col-md-12">
            <h2>{{ $title }} <a href="{{ route('auth.cabinets.create') }}"><i class="material-icons">add_box</i></a></h2>
                @foreach($cabinets as $item)
                <div class="row">
                    <div class="col-sm-12">
                        <h1>{{ $item->name }}</h1>
                        <div class="row">
                            <div class="col-4 col-sm-12">
                                <img src="{{ $item->cabinetPreviewPhoto()->photo }}" alt="{{ $item->name }}" width="35%" style="float:left; margin: 7px 7px 7px 0;">
                                {!! htmlspecialchars_decode($item->description) !!}
                            </div>
                            <a href="cabinets/{{ $item->id }}" class="btn btn-primary" style="float:right; margin: 7px 7px 7px 0;">редактировать</a>
                        </div>
                    </div>
                </div>
                @endforeach
        </div>
    </div>
</div> 

@endsection