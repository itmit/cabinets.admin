@extends('layouts.adminApp')

@section('content')

<div class="col-sm-12 tabs-content">
    <div class="row justify-content-center cont-m">
        <div class="col-md-12">
            <h2>{{ $title }}</h2>
            <form class="form-horizontal" method="POST" action="{{ route('auth.reservations.store') }}" enctype="multipart/form-data">
                {{ csrf_field() }}
            
                <div class="form-group{{ $errors->has('cabinet') ? ' has-error' : '' }}">
                    <div class="col-xs-12 col-sm-2">
                    <label for="cabinet" class="control-label text-tc">Выбрать кабинет</label>
                    </div>
            
                    <div class="col-xs-12 col-sm-10">
                        <select name="cabinet" class="form-control" required>
                            <option selected disable>Кабинет</option>
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

                <div class="form-group{{ $errors->has('client') ? ' has-error' : '' }}">
                    <div class="col-xs-12 col-sm-2">
                    <label for="client" class="control-label text-tc">Выбрать клиента</label>
                    </div>
            
                    <div class="col-xs-12 col-sm-10">
                        <select name="client" class="form-control" required>
                            <option selected disable>Клиент</option>
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
        
    });
</script>
@endsection