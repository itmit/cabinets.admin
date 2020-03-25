@extends('layouts.adminApp')

@section('content')

<div class="col-sm-12 tabs-content">
    <div class="row justify-content-center cont-m">
        <div class="col-md-12">
            <h2>{{ $title }}</h2>
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Отменены</a>
                    <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Отменены менее чем за 24 ч</a>
                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">...</div>
                <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">...</div>
              </div>
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