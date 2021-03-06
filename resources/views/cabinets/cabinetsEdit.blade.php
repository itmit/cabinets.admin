@extends('layouts.adminApp')

@section('content')

<div class="col-sm-12 tabs-content">
    <div class="row justify-content-center cont-m">
        <div class="col-md-12">
            <h2>Редактирование кабинета</h2>

            <a href="..">Назад</a>

            <form class="form-horizontal" method="POST" action="/cabinets/{{ $id }}" enctype="multipart/form-data">
            {{ method_field('PATCH') }}
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

                <div class="row form-group{{ $errors->has('price_morning') ? ' has-error' : '' }}">
                    <div class="col-xs-12 col-sm-2">
                    <label for="price_morning" class="control-label text-tc">Цена с 7.00 до 17.00</label>
                    </div>
            
                    <div class="col-xs-12 col-sm-10">
                        <input id="price_morning" type="text" class="form-control" name="price_morning" value="{{ $cabinet->price_morning }}" required>
            
                        @if ($errors->has('price_morning'))
                            <span class="help-block">
                                <strong>{{ $errors->first('price_morning') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="row form-group{{ $errors->has('price_evening') ? ' has-error' : '' }}">
                    <div class="col-xs-12 col-sm-2">
                    <label for="price_evening" class="control-label text-tc">Цена с 17.00 до 23.00</label>
                    </div>
            
                    <div class="col-xs-12 col-sm-10">
                        <input id="price_evening" type="text" class="form-control" name="price_evening" value="{{ $cabinet->price_evening }}" required>
            
                        @if ($errors->has('price_evening'))
                            <span class="help-block">
                                <strong>{{ $errors->first('price_evening') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="row form-group{{ $errors->has('color') ? ' has-error' : '' }}">
                    <div class="col-xs-12 col-sm-2">
                    <label for="color" class="control-label text-tc">Цвет</label>
                    </div>
            
                    <div class="col-xs-12 col-sm-10">
                        <select id="color" type="color" class="form-control" name="color" value="{{ old('color') }}" required>
                            <option value="1" @if($cabinet->color == 1) selected @endif>blue</option>
                            <option value="2" @if($cabinet->color == 2) selected @endif>green</option>
                            <option value="3" @if($cabinet->color == 3) selected @endif>purple</option>
                            <option value="4" @if($cabinet->color == 4) selected @endif>red</option>
                            <option value="5" @if($cabinet->color == 5) selected @endif>yellow</option>
                            <option value="6" @if($cabinet->color == 6) selected @endif>orange</option>
                            <option value="7" @if($cabinet->color == 7) selected @endif>turquoise</option>
                            <option value="8" @if($cabinet->color == 8) selected @endif>gray</option>
                            <option value="9" @if($cabinet->color == 9) selected @endif>bold blue</option>
                            <option value="10" @if($cabinet->color == 10) selected @endif>bold green</option>
                            <option value="11" @if($cabinet->color == 11) selected @endif>bold red</option>
                        </select>
            
                        @if ($errors->has('color'))
                            <span class="help-block">
                                <strong>{{ $errors->first('color') }}</strong>
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
                        " data-photo="{{ $item->id }}" class="clear_photo"><i class="material-icons">clear</i></span>
                            <a href="{{ $item->photo }}" target="_blank" rel="noopener noreferrer">
                                <img src="{{ $item->photo }}"style="width:100%">
                            </a>
                        </div>
                    </div>
                    
                    @endforeach
                </div>
            
                <div class="form-group">
                    <div class="col-sm-12">
                        <button type="submit" class="btn btn-primary">
                            Сохранить
                        </button>
                    </div>
                </div>

            </form>

            <hr>

            <small>
                <p>
                    Кабинет создан: {{ $cabinet->created_at }}
                </p>
                <p>
                    Кабинет обновлен: {{ $cabinet->updated_at }}
                </p>
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

<script>
 $(document).ready(function()
    {
        let ids = [];

        $('.clear_photo').click(function () {
            if(jQuery.inArray($(this).data('photo'), ids) == -1)
            {
                let isDel = confirm("Удалить фотографию?");
                if(isDel)
                {
                    ids.push($(this).data('photo'));
                    let photo = $(this).data('photo');
                    let delPhoto =  $(this).closest('.col-md-4');
                    // $(this).closest('.thumbnail').css('opacity', '50%');
                    $.ajax({
                        headers : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        dataType: "json",
                        data    : { photo: photo },
                        url     : '../deletePhoto',
                        method    : 'post',
                        success: function (response) {
                            delPhoto.remove();
                        },
                        error: function (xhr, err) { 
                            console.log("Error: " + xhr + " " + err);
                        }
                    });
                }
            }
        })
    })
</script>

@endsection