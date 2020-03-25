@extends('layouts.adminApp')

@section('content')

<div class="col-sm-12 tabs-content">
    <div class="row justify-content-center cont-m">
        <div class="col-md-12">
            <h2>{{ $title }}</h2>
            <ul class="nav nav-tabs" id="myTab">
                <li data-type="cancel" class="active"><a href="#">Отменены</a></li>
                <li data-type="cancel2"><a href="#">Отменены менее чем за 24 ч</a></li>
            </ul>
            <table class="table policy-table">
                <thead>
                <tr>
                    <th scope="col">Дата</th>
                    <th scope="col">Кабинет</th>
                    <th scope="col">Клиент</th>
                </tr>
                </thead>
                <tbody>
                {{-- @foreach($clients as $item)
                    <tr data-c="{{ $item['client']->id }}" style="cursor: pointer">
                        <td>{{ $item['client']->name }}</td>
                        <td>{{ $item['client']->getReservationCount() }}</td>
                        <td>{{ $item['amount'] }} рублей</td>
                    </tr>
                @endforeach --}}
                </tbody>
            </table>
        </div>
    </div>
</div> 

<script>
// $("tr").click(function() {
//     window.location.href = 'reservationcancels/'+$(this).data('c');
// });
$('#myTab a').on('click', function (e) {
  e.preventDefault()
  $(this).tab('show')
})
</script>
@endsection