@extends('layouts.adminApp')

@section('content')

<div class="col-sm-12 tabs-content">
    <div class="row justify-content-center cont-m">
        <div class="col-md-12">
        <h2>{{ $title }} {{ $client->name }}</h2>

            <a href="../clients">Назад</a>
            
            {{-- <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                <div class="col-xs-12 col-sm-2">
                <label for="name" class="control-label text-tc">Название кабинета</label>
                </div>
        
                <div class="col-xs-12 col-sm-10">
                    <input id="name" type="text" class="form-control" name="name" value="{{ $cabinet->name }}" required maxlength="191" placeholder=" Кабинет #">
        
                    @if ($errors->has('name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                </div>
            </div> --}}
            
        </div>
    </div>
</div> 

@endsection