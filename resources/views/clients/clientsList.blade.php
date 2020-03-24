@extends('layouts.adminApp')

@section('content')

<div class="col-sm-12 tabs-content">
    <div class="row justify-content-center cont-m">
        <div class="col-md-12">
            <h2>{{ $title }}<a href="{{ route('auth.clients.create') }}"><i class="material-icons">add_box</i></a></h2>
            <table class="table policy-table">
                <thead>
                <tr>
                    <th scope="col">ФИО</th>
                    <th scope="col">Количество бронирований</th>
                    <th scope="col">Задолженность</th>
                    <th scope="col">Статус</th>
                </tr>
                </thead>
                <tbody>
                @foreach($clients as $item)
                    <tr data-c="{{ $item['client']->id }}" style="cursor: pointer">
                        <td>{{ $item['client']->name }}</td>
                        <td>{{ $item['client']->getReservationCount() }}</td>
                        <td>{{ $item['amount'] }} рублей</td>
                        <td>@if($item['client']->deleted_at == null)
                                Активен
                            @else
                                Архивирован
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div> 

<script>
$("tr").click(function() {
    window.location.href = 'clients/'+$(this).data('c');
});
</script>
@endsection