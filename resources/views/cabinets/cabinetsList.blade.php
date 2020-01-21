@extends('layouts.adminApp')

@section('content')

<div class="col-sm-12 tabs-content">
    <div class="row justify-content-center cont-m">
        <div class="col-md-12">
            <h2>{{ $title }} <a href="{{ route('auth.cabinets.create') }}"><i class="material-icons">add_box</i></a></h2>
                {{-- @foreach($cabinets as $item)
                @endforeach --}}
        </div>
    </div>
</div> 

@endsection