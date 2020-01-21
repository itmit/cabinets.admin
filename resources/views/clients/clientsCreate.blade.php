@extends('layouts.adminApp')

@section('content')

<div class="col-sm-12 tabs-content">
    <div class="row justify-content-center cont-m">
        <div class="col-md-12">
            <h2>{{ $title }}</h2>
            <form class="form-horizontal" method="POST" action="{{ route('auth.clients.store') }}" enctype="multipart/form-data">
                {{ csrf_field() }}
            
                <div class="form-group{{ $errors->has('news_head') ? ' has-error' : '' }}">
                    <div class="col-xs-12 col-sm-2">
                    <label for="news_head" class="control-label text-tc">ФИО</label>
                    </div>
            
                    <div class="col-xs-12 col-sm-10">
                        <input id="news_head" type="text" class="form-control" name="news_head" value="{{ old('news_head') }}" required maxlength="191">
            
                        @if ($errors->has('news_head'))
                            <span class="help-block">
                                <strong>{{ $errors->first('news_head') }}</strong>
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