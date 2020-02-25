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
                <div class="col-md-8"><p>{{ $amount }} рублей</p></div>
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
                        <div class="col-xs-4 col-sm-4">
                            <p>Стоимость: </p>
                        </div>
                        <div class="col-xs-8 col-sm-8">
                            <p>
                                {{ $item->total_amount }} рублей
                            </p>    
                        </div>
                        <div class="col-xs-4 col-sm-4">
                            <p>Статус: </p>
                        </div>
                        <div class="col-xs-8 col-sm-8">
                            <p>
                                @if ($item->is_paid == 1)
                                    Оплачено
                                @else
                                    Не оплачено
                                @endif
                            </p>
                            @if ($item->is_paid == 0)
                                <input type="button" onclick="rPaid()" value="Оплатить" data-r="{{ $item->uuid }}">
                            @endif
                        </div>
                      </div>
                    </div>
                  </div>
            @endforeach
            
        </div>
    </div>
</div> 
<script>
    $(document).ready(function()
    {
        function rPaid () {
            reservation = $(this).data('r');
            $.ajax({
                headers : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                dataType: "json",
                data: {reservation: reservation},
                url     : 'reservation/paid',
                method    : 'post',
                success: function (response) {
                    console.log(response);
                    // location.reload();
                },
                error: function (xhr, err) { 
                    console.log(err + " " + xhr);
                }
            });
        };
    })
</script>
@endsection