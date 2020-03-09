@extends('layouts.adminApp')

@section('content')

<div class="col-sm-12 tabs-content">
    <div class="row justify-content-center cont-m">
        <div class="col-md-12">
            <h2>{{ $title }}</h2>
            <form class="form-horizontal" method="POST" action="{{ route('auth.reservations.store') }}" enctype="multipart/form-data">
                {{ csrf_field() }}
            
                <div class="form-group{{ $errors->has('client') ? ' has-error' : '' }}">
                    <div class="col-xs-12 col-sm-2">
                    <label for="client" class="control-label text-tc">Выбрать клиента</label>
                    </div>
            
                    <div class="col-xs-12 col-sm-10">
                        <select name="client" class="form-control" required>
                            <option value="" selected disabled>Клиент</option>
                            @foreach ($clients as $client)
                                <option value="{{ $client->id }}">{{ $client->name }}</option>
                            @endforeach
                        </select>
            
                        @if ($errors->has('client'))
                            <span class="help-block">
                                <strong>{{ $errors->first('client') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('cabinet') ? ' has-error' : '' }}">
                    <div class="col-xs-12 col-sm-2">
                    <label for="cabinet" class="control-label text-tc">Выбрать кабинет</label>
                    </div>
            
                    <div class="col-xs-12 col-sm-10">
                        <select name="cabinet" class="form-control cabinetAndDateSelect" required id="cabinetAndDateSelect">
                            <option value="" selected disabled>Кабинет</option>
                            @foreach ($cabinets as $cabinet)
                                <option value="{{ $cabinet->id }}">{{ $cabinet->name }}</option>
                            @endforeach
                        </select>
            
                        @if ($errors->has('cabinet'))
                            <span class="help-block">
                                <strong>{{ $errors->first('cabinet') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('date') ? ' has-error' : '' }}">
                    <div class="col-xs-12 col-sm-2">
                    <label for="date" class="control-label text-tc">Выбрать дату</label>
                    </div>
            
                    <div class="col-xs-12 col-sm-10">
                        <input type="date" name="date" id="cabinetAndDateSelect" class="form-control cabinetAndDateSelect" required>
            
                        @if ($errors->has('date'))
                            <span class="help-block">
                                <strong>{{ $errors->first('date') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('times') ? ' has-error' : '' }}">
                    <div class="col-xs-12 col-sm-2">
                    <label for="times" class="control-label text-tc">Выбрать время</label>
                    </div>
            
                    <div class="col-xs-12 col-sm-10">
                        <select name="times" class="form-control" required>
                            <option value="" selected disabled>Время</option>
                            
                        </select>
            
                        @if ($errors->has('times'))
                            <span class="help-block">
                                <strong>{{ $errors->first('times') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
            
                <div class="form-group">
                    <div class="col-sm-12">
                        <button type="submit" class="btn btn-primary">
                            Сохранить
                        </button>
                    </div>
                </div>
            
            </form>
        </div>
    </div>
</div> 
<script>
    $(document).ready(function () {
        $(".cabinetAndDateSelect").change(function() {
            let cab = $('select[name="cabinet"]').val();
            let date = $('input[name="date"]').val();
            // console.log(cab + ' ' + date);
            // console.log($(this).children("option:selected").val());
            $.ajax({
                headers : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                dataType: "json",
                data: {date: date, cabinet: cab},
                url     : 'reservations/getTimes',
                method    : 'post',
                success: function (response) {
                    console.log(response);
                },
                error: function (xhr, err) { 
                    console.log(err + " " + xhr);
                }
            });
        });
    });
</script>
@endsection