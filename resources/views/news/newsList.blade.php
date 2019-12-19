@extends('layouts.adminApp')

@section('content')

<div class="col-sm-12 tabs-content">
    <div class="row justify-content-center cont-m">
        <div class="col-md-12">
            <h2>{{ $title }}</h2>
            <a href="{{ route('auth.news.create') }}" class="btn btn-primary">Добавить новость</a>
            @foreach($news as $item)

            <div class="row">
                <div class="col-sm-12">
                    <h1>{{ $item->head }}<i class="material-icons delete-news" style="cursor: pointer" data-id="{{ $item->id }}">delete</i></h1>
                    <div class="row">
                        <div class="col-4 col-sm-12">
                            <img src="{{ $item->preview_picture }}" alt="{{ $item->head }}" width="35%" style="float:left; margin: 7px 7px 7px 0;">
                            {!! htmlspecialchars_decode($item->body) !!}
                        </div>
                        <a href="news/{{ $item->id }}" class="btn btn-primary" style="float:right; margin: 7px 7px 7px 0;">подробнее</a>
                    </div>
                </div>
            </div>
            
            @endforeach
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