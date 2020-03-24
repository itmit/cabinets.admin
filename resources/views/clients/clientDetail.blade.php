@extends('layouts.adminApp')

@section('content')

<div class="col-sm-12 tabs-content">
    <div class="row justify-content-center cont-m">
        <div class="col-md-12">
        <h2>{{ $title }} {{ $client->name }}</h2>

            <a href="../clients">Назад</a>

            <div class="row">
                <div class="col-md-3"><a href="/clients/{{ $client->id }}/edit" class="btn btn-primary">Редактировать</a></div>
                <div class="col-md-3">
                    @if($client->deleted_at == null)
                    <button class="btn btn-danger archive" data-i="{{ $client->id }}">Архивировать</button>
                    @else
                    <button class="btn btn-danger unarchive" data-i="{{ $client->id }}">Разархивировать</button>
                    @endif
                </div>
            </div>
            
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
                        <p>Бронирование кабинета <b><a href="../cabinets/{{ $cabinet->id }}/edit">{{ $cabinet->name }}</a></b><i class="material-icons" style="color: {{ $cabinet->color_html }}">home</i> ({{ $item->date }})</p>
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
                            @if($item->deleted_at != null)
                                @if ($item->is_paid == 0)
                                    <input type="button" class="btn btn-primary paid" value="Оплатить" data-r="{{ $item->uuid }}">
                                    <input type="button" class="btn btn-danger cancel" value="Отменить" data-r="{{ $item->uuid }}">
                                @endif
                            @else
                                <p>Бронирование было отменено</p>
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
        $(".paid").click(function() {
            reservation = $(this).data('r');
            $.ajax({
                headers : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                dataType: "json",
                data: {reservation: reservation},
                url     : 'paid',
                method    : 'post',
                success: function (response) {
                    // console.log(response);
                    location.reload();
                },
                error: function (xhr, err) { 
                    console.log(err + " " + xhr);
                }
            });
        });

        $(".cancel").click(function() {
            reservation = $(this).data('r');
            $.ajax({
                headers : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                dataType: "json",
                data: {uuid: reservation},
                url     : 'cancel',
                method    : 'post',
                success: function (response) {
                    // console.log(response);
                    location.reload();
                },
                error: function (xhr, err) { 
                    console.log(err + " " + xhr);
                }
            });
        });

        $(".archive").click(function() {
            let isDel = confirm("Архивировать клиента? Все его текущие бронирования будут отменены!");
            if(isDel)
            {
                id = $(this).data('i');
                $.ajax({
                    headers : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    dataType: "json",
                    data: {id: id},
                    url     : 'archive',
                    method    : 'post',
                    success: function (response) {
                        // console.log(response);
                        location.reload();
                    },
                    error: function (xhr, err) { 
                        console.log(err + " " + xhr);
                    }
                });
            }
        });

        $(".unarchive").click(function() {
            id = $(this).data('i');
            $.ajax({
                headers : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                dataType: "json",
                data: {id: id},
                url     : 'unarchive',
                method    : 'post',
                success: function (response) {
                    // console.log(response);
                    location.reload();
                },
                error: function (xhr, err) { 
                    console.log(err + " " + xhr);
                }
            });
        });
    })
</script>
@endsection