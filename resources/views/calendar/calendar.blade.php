@extends('layouts.adminApp')

@section('content')

<div class="col-sm-12 tabs-content">
    <div class="row justify-content-center cont-m">
        <div class="col-md-12">
            <h2>{{ $title }} <i class="material-icons">calendar_today</i></h2>
            <div class="row">
                <div class="col-sm-12">
                    <input type="date" name="" class="form-control">
                </div>
            </div>
        </div>
    </div>
</div> 

@endsection