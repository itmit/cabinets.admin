@extends('layouts.adminApp')

@section('content')

<div class="col-sm-12 tabs-content">
    <div class="row justify-content-center cont-m">
        <div class="col-md-12">
            <h2>{{ $title }}</h2>
            <form class="form-horizontal" method="POST" action="{{ route('auth.news.store') }}" enctype="multipart/form-data">
                {{ csrf_field() }}
            
                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                    <div class="col-xs-12 col-sm-2">
                    <label for="name" class="control-label text-tc">Название кабинета</label>
                    </div>
            
                    <div class="col-xs-12 col-sm-10">
                        <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required maxlength="191" placeholder=" Кабинет #">
            
                        @if ($errors->has('name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('area') ? ' has-error' : '' }}">
                    <div class="col-xs-12 col-sm-2">
                    <label for="area" class="control-label text-tc">Площадь</label>
                    </div>
            
                    <div class="col-xs-12 col-sm-10">
                        <input id="area" type="number" step="0.1" min="1" max="9999" class="form-control" name="area" value="{{ old('area') }}" required maxlength="191">
            
                        @if ($errors->has('area'))
                            <span class="help-block">
                                <strong>{{ $errors->first('area') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
            
                <div class="row form-group{{ $errors->has('capacity') ? ' has-error' : '' }}">
                    <div class="col-xs-12 col-sm-2">
                    <label for="capacity" class="control-label text-tc">Вместимость</label>
                    </div>
            
                    <div class="col-xs-12 col-sm-10">
                        <input id="capacity" type="number" step="1" min="1" max="999" class="form-control" name="capacity" value="{{ old('capacity') }}" required maxlength="191">
            
                        @if ($errors->has('capacity'))
                            <span class="help-block">
                                <strong>{{ $errors->first('capacity') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="row form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                    <div class="col-xs-12 col-sm-2">
                    <label for="description" class="control-label text-tc">Описание</label>
                    </div>
            
                    <div class="col-xs-12 col-sm-10">
                        <textarea name="description" cols="30" rows="10" class="form-control">{{ old('description') }}</textarea>
            
                        @if ($errors->has('description'))
                            <span class="help-block">
                                <strong>{{ $errors->first('description') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('photos') ? ' has-error' : '' }}">
                    <div class="col-xs-12 col-sm-2">
                    <label for="photos" class=" control-label text-tc">Фотографии</label>
                    </div>
                
                    <div class="col-xs-12 col-sm-10">
                        <input type="file" name="photos[]" id="photos" class="form-control-file" accept="image/*" multiple>
            
                        @if ($errors->has('photos'))
                            <span class="help-block">
                                <strong>{{ $errors->first('photos') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
            
                <div class="form-group">
                    <div class="col-sm-12">
                        <button type="submit" class="btn btn-tc-ct">
                            Сохранить
                        </button>
                    </div>
                </div>
            
            </form>
        </div>
    </div>
</div> 

@endsection