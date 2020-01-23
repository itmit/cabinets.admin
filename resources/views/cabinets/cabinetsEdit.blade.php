@extends('layouts.adminApp')

@section('content')

<div class="col-sm-12 tabs-content">
    <div class="row justify-content-center cont-m">
        <div class="col-md-12">
            <h2>Редактирование кабинета</h2>

            <a href="../cabinets">Назад</a>

            <form class="form-horizontal" method="POST" action="{{ route('auth.cabinets.update', ['id' => $cabinet->id]),  }}" enctype="multipart/form-data">
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

                <div class="form-group{{ $errors->has('area') ? ' has-error' : '' }}">
                    <div class="col-xs-12 col-sm-2">
                    <label for="area" class="control-label text-tc">Площадь</label>
                    </div>
            
                    <div class="col-xs-12 col-sm-10">
                        <input id="area" type="number" step="0.1" min="1" max="9999" class="form-control" name="area" value="{{ $cabinet->area }}" required maxlength="191">
            
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
                        <input id="capacity" type="number" step="1" min="1" max="999" class="form-control" name="capacity" value="{{ $cabinet->capacity }}" required maxlength="191">
            
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
                        <textarea name="description" cols="30" rows="10" class="form-control">{{ $cabinet->description }}</textarea>
            
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
            
                <div class="form-group">
                    <div class="col-sm-12">
                        <button type="submit" class="btn btn-tc-ct">
                            Сохранить
                        </button>
                    </div>
                </div>

            </form>

            <hr>

            <small>
                Кабинет создан: {{ $cabinet->created_at }}
                Кабинет обновлен: {{ $cabinet->updated_at }}
            </small>

            <div class="form-group">
                <div class="col-sm-12">
                    <button type="button" class="btn btn-danger" disabled>
                        Удалить кабинет
                    </button>
                </div>
            </div>
            
        </div>
    </div>
</div> 

@endsection