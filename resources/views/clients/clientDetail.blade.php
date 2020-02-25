@extends('layouts.adminApp')

@section('content')

<div class="col-sm-12 tabs-content">
    <div class="row justify-content-center cont-m">
        <div class="col-md-12">
        <h2>{{ $title }} {{ $client->name }}</h2>

            <a href="../clients">Назад</a>
            
            <div class="form-group">
                <div class="col-xs-12 col-sm-2">
                <label for="phone" class="control-label text-tc">Телефон</label>
                </div>
        
                <div class="col-xs-12 col-sm-10">
                    <p id="phone">{{ $client->phone }}</p>
                </div>
            </div>

            <div class="form-group">
                <div class="col-xs-12 col-sm-2">
                <label for="email" class="control-label text-tc">Эл. почта</label>
                </div>
        
                <div class="col-xs-12 col-sm-10">
                    <p id="email">{{ $client->email }}</p>
                </div>
            </div>

            <div class="form-group">
                <div class="col-xs-12 col-sm-2">
                <label for="birthday" class="control-label text-tc">Дата рождения</label>
                </div>
        
                <div class="col-xs-12 col-sm-10">
                    <p id="birthday">{{ $client->birthday }}</p>
                </div>
            </div>

            <hr>

            <div class="form-group">
                <div class="col-xs-12 col-sm-2">
                <label for="getReservationCount" class="control-label text-tc">Количество бронирований</label>
                </div>
        
                <div class="col-xs-12 col-sm-10">
                    <p id="getReservationCount">{{ $client->getReservationCount() }}</p>
                </div>
            </div>

            <div class="form-group">
                <div class="col-xs-12 col-sm-2">
                <label for="amount" class="control-label text-tc">Общая сумма к оплате</label>
                </div>
        
                <div class="col-xs-12 col-sm-10">
                    <p id="amount">{{ $amount }} рублей</p>
                </div>
            </div>
            
        </div>
    </div>
</div> 

@endsection