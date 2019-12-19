@extends('layouts.adminApp')

@section('content')

<div class="col-sm-12 tabs-content">
    <div class="row justify-content-center cont-m">
        <div class="col-md-12">
            <h2>{{ $title }}</h2>
            <a href="{{ route('auth.clients.create') }}" class="btn btn-primary">Добавить клиена</a>
            <table class="table policy-table">
                <thead>
                <tr>
                    <th scope="col">ФИО</th>
                    <th scope="col">Эл. почта</th>
                    <th scope="col">Телефон</th>
                    <th scope="col">Количество бронирований</th>
                    <th scope="col">Статус</th>
                </tr>
                </thead>
                <tbody>
                @foreach($clients as $item)
                    <tr>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->email }}</td>
                        <td>{{ $item->phone }}</td>
                        <td></td>
                        <td></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div> 

<script>

// $(document).on('click', '.delete-news', function() {
//     let isDelete = confirm("Удалить новость? Данное действие невозможно отменить!");

//     if(isDelete)
//     {
//         let id = $(this).data('id');
//         $.ajax({
//             headers : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
//             dataType: "json",
//             data    : { id: id },
//             url     : 'news/delete',
//             method    : 'delete',
//             success: function (response) {
//                 $(this).closest('.row').remove();
//                 console.log('Удалено!');
//             },
//             error: function (xhr, err) { 
//                 console.log("Error: " + xhr + " " + err);
//             }
//         });
//     }
// });

</script>
@endsection