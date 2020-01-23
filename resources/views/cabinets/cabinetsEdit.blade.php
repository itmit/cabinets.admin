@extends('layouts.adminApp')

@section('content')

<div class="col-sm-12 tabs-content">
    <div class="row justify-content-center cont-m">
        <div class="col-md-12">
            <h2>Редактирование кабинета</h2>

            <a href="../cabinets">Назад</a>

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