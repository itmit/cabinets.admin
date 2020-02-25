@extends('layouts.adminApp')

@section('content')

<div class="col-sm-12 tabs-content">
    <div class="row justify-content-center cont-m">
        <div class="col-md-12">
        <h2>{{ $title }} {{ $client->name }}</h2>

            <a href="../clients">Назад</a>
            
            <div class="row">
                <div class="col-md-4">Телефон</div>
                <div class="col-md-8"><p>{{ $client->phone }}</p></div>
            </div>

            <div class="row">
                <div class="col-md-4">Эл. почта</div>
                <div class="col-md-8"><p>{{ $client->email }}</p></div>
            </div>

            <div class="row">
                <div class="col-md-4">Дата рождения</div>
                <div class="col-md-8"><p>{{ $client->birthday }}</p></div>
            </div>

            <hr>

            <div class="row">
                <div class="col-md-4">Количество бронирований</div>
                <div class="col-md-8"><p>{{ $client->getReservationCount() }}</p></div>
            </div>

            <div class="row">
                <div class="col-md-4">Общая сумма к оплате</div>
                <div class="col-md-8"><p>{{ $amount }}</p></div>
            </div>

            @foreach ($reservations as $item)
            <?
            $cabinet = $item->getCabinet();
            $times = $item->getTimes();
            ?>
                <hr>

                <div class="row">
                    <div class="col-sm-9">
                        <p>Бронирование кабинета <b><a href="../cabinets/{{ $cabinet->id }}">{{ $cabinet->name }}</a></b><i class="material-icons" style="color: {{ $cabinet->color }}">home</i> ({{ $item->date }})</p>
                      <div class="row">
                        <div class="col-xs-4 col-sm-4">
                            <p>Время: </p>
                        </div>
                        <div class="col-xs-8 col-sm-8">
                            <ul>
                                @foreach ($times as $time)
                                <li>
                                    {{ $time->time }} ({{ $time->price }} рублей)
                                </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="col-xs-4 col-sm-8">
                            <p>Стоимость: </p>
                        </div>
                        <div class="col-xs-4 col-sm-8">
                            <p>
                                {{ $item->total_amount }} рублей
                            </p>    
                        </div>
                      </div>
                    </div>
                  </div>
            @endforeach
            
        </div>
    </div>
</div> 

@endsection