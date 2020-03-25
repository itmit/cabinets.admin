@extends('layouts.adminApp')

@section('content')

<div class="col-sm-12 tabs-content">
    <div class="row justify-content-center cont-m">
        <div class="col-md-12">
            <h2>{{ $title }}</h2>
            <ul class="nav nav-tabs">
            <li class="active">
                <a data-toggle="tab" href="#c1">Отменены</a>
            </li>
            <li>
                <a data-toggle="tab" href="#c2">Отменены менее чем за 24 ч</a>
            </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="c1">
                    <table class="table policy-table">
                        <thead>
                        <tr>
                            <th scope="col">Дата</th>
                            <th scope="col">Кабинет</th>
                            <th scope="col">Клиент</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($reservations1 as $reservation1)
                            <tr>
                                <td>{{ $reservation1->date }}</td>
                                <td>{{ $reservation1->getCabinet()->name }}</td>
                                <td>{{ $reservation1->getClient()->name }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane" id="c2">
                    <table class="table policy-table">
                        <thead>
                        <tr>
                            <th scope="col">Дата</th>
                            <th scope="col">Кабинет</th>
                            <th scope="col">Клиент</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($reservations2 as $reservation2)
                            <tr>
                                <td>{{ $reservation2->date }}</td>
                                <td>{{ $reservation2->getCabinet()->name }}</td>
                                <td>{{ $reservation2->getClient()->name }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
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