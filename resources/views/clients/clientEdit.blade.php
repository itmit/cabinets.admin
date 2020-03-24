@extends('layouts.adminApp')

@section('content')

<div class="col-sm-12 tabs-content">
    <div class="row justify-content-center cont-m">
        <div class="col-md-12">
            <h2>{{ $title }}</h2>
            <form class="form-horizontal" method="POST" action="/clients/{{ $id }}" enctype="multipart/form-data">
                {{ method_field('PATCH') }}
                {{ csrf_field() }}
            
                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                    <div class="col-xs-12 col-sm-2">
                    <label for="name" class="control-label text-tc">Фамилия имя</label>
                    </div>
            
                    <div class="col-xs-12 col-sm-10">
                        <input id="name" type="text" class="form-control" name="name" value="{{ $client->name }}" required maxlength="191" placeholder=" Иванов Иван">
            
                        @if ($errors->has('name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('birthday') ? ' has-error' : '' }}">
                    <div class="col-xs-12 col-sm-2">
                    <label for="birthday" class="control-label text-tc">Дата рождения</label>
                    </div>
            
                    <div class="col-xs-12 col-sm-10">
                        <input id="birthday" type="date" class="form-control" name="birthday" value="{{ $client->birthday }}" required maxlength="191">
            
                        @if ($errors->has('birthday'))
                            <span class="help-block">
                                <strong>{{ $errors->first('birthday') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                    <div class="col-xs-12 col-sm-2">
                    <label for="phone" class="control-label text-tc">Номер телефона</label>
                    </div>
            
                    <div class="col-xs-12 col-sm-10">
                        <input id="phone" type="tel" class="form-control" name="phone" value="{{ $client->phone }}" required maxlength="191">
            
                        @if ($errors->has('phone'))
                            <span class="help-block">
                                <strong>{{ $errors->first('phone') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <div class="col-xs-12 col-sm-2">
                    <label for="email" class="control-label text-tc">E-mail</label>
                    </div>
            
                    <div class="col-xs-12 col-sm-10">
                        <input id="email" type="email" class="form-control" name="email" value="{{ $client->email }}" required maxlength="191">
            
                        @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <div class="col-xs-12 col-sm-2">
                    <label for="password" class="control-label text-tc">Пароль</label>
                    </div>
            
                    <div class="col-xs-12 col-sm-10">
                        <input id="password" type="password" class="form-control" name="password" value="{{ $client->password }}" required maxlength="191">
            
                        @if ($errors->has('password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                    <div class="col-xs-12 col-sm-2">
                    <label for="password_confirmation" class="control-label text-tc">Повторите пароль</label>
                    </div>
            
                    <div class="col-xs-12 col-sm-10">
                        <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" value="" required maxlength="191">
            
                        @if ($errors->has('password_confirmation'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password_confirmation') }}</strong>
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
        $('input[type=tel]').mask("+7 (999) 999-99-99");
    });
</script>
@endsection