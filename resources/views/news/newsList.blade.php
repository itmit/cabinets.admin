@extends('layouts.adminApp')

@section('content')
    
    <a href="{{ route('auth.news.create') }}" class="btn btn-primary">Добавить новость</a>

    <br>

    {{-- @foreach($news as $newsItem)

    <div class="row">
        <div class="col-sm-12">
            <h1>{{ $newsItem->head }}<i class="material-icons delete-news" style="cursor: pointer" data-id="{{ $newsItem->id }}">delete</i></h1>
            <div class="row">
            <div class="col-4 col-sm-12">
                <img src="{{ $newsItem->picture }}" alt="{{ $newsItem->head }}" width="35%" style="float:left; margin: 7px 7px 7px 0;">
                {!! htmlspecialchars_decode($newsItem->body) !!}
            </div>
            </div>
        </div>
    </div>
    
    @endforeach --}}
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