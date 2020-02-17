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
                                <img src="{{ $item->cabinetPreviewPhoto()->photo }}" alt="{{ $item->name }}" width="25%" style="float:left; margin: 7px 7px 7px 0;">
                                <p>{{ $item->description }}</p>
                                <p>Цена с 7.00 до 17.00: {{ $item->price_morning }} руб/час, с 17.00 до 23.00: {{ $item->price_evening }}</p>
                                <a href="cabinets/{{ $item->id }}/edit" class="btn btn-primary" style="float:left; margin: 7px 7px 7px 0;">редактировать</a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
        </div>
    </div>
</div> 

@endsection