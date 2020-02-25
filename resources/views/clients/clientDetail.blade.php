@extends('layouts.adminApp')

@section('content')

<div class="col-sm-12 tabs-content">
    <div class="row justify-content-center cont-m">
        <div class="col-md-12">
        <h2>{{ $title }} {{ $client->name }}</h2>

            <a href="../clients">Назад</a>
            
            <div class="row">
                <div class="col-md-6">Телефон</div>
                <div class="col-md-6"><p>{{ $client->phone }}</p></div>
            </div>

            <div class="row">
                <div class="col-md-6">Эл. почта</div>
                <div class="col-md-6"><p>{{ $client->email }}</p></div>
            </div>

            <div class="row">
                <div class="col-md-6">Дата рождения</div>
                <div class="col-md-6"><p>{{ $client->birthday }}</p></div>
            </div>

            <hr>

            <div class="row">
                <div class="col-md-6">Количество бронирований</div>
                <div class="col-md-6"><p>{{ $client->getReservationCount() }}</p></div>
            </div>

            <div class="row">
                <div class="col-md-6">Общая сумма к оплате</div>
                <div class="col-md-6"><p>{{ $amount }}</p></div>
            </div>
            
        </div>
    </div>
</div> 

@endsection