@extends('layouts.adminApp')

@section('content')

<div class="col-sm-12 tabs-content">
    <div class="row justify-content-center cont-m">
        <div class="col-md-12">
            <h2>Редактирование кабинета</h2>

            <a href="../cabinets">Назад</a>

            <form class="form-horizontal" method="POST" action="{{ route('auth.cabinets.edit') }}" enctype="multipart/form-data">
                {{ csrf_field() }}
            
                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
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
                </div>

            </form>

            <div class="row">
                @foreach($photos as $item)

                <div class="col-md-4">
                    <div class="thumbnail">
                        <span style="
                        float: right;
                        z-index: 100;
                        position: absolute;
                        right: 20px;
                        cursor: pointer;
                    " data-photo="{{ $item->id }}"><i class="material-icons">clear</i></span>
                        <a href="{{ $item->photo }}">
                            <img src="{{ $item->photo }}"style="width:100%">
                        </a>
                    </div>
                </div>
                
                @endforeach
            </div>
        </div>
    </div>
</div> 

@endsection