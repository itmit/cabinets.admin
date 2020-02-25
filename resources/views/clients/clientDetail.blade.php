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

            @foreach ($reservations as $item)
            <?
            $cabinet = $item->getCabinet();
            ?>
                <hr>

                <div class="row">
                    <div class="col-sm-9">
                      <p>Бронирование кабинета {{ $cabinet->name }}<i class="material-icons" style="color: {{ $cabinet->color }}">home</i></p>
                      <div class="row">
                        <div class="col-xs-8 col-sm-6">
                          Level 2: .col-xs-8 .col-sm-6
                        </div>
                        <div class="col-xs-4 col-sm-6">
                          Level 2: .col-xs-4 .col-sm-6
                        </div>
                      </div>
                    </div>
                  </div>
            @endforeach
            
        </div>
    </div>
</div> 

@endsection