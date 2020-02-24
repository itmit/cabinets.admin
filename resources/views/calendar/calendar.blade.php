@extends('layouts.adminApp')

@section('content')

<div class="col-sm-12 tabs-content">
    <div class="row justify-content-center cont-m">
        <div class="col-md-12">
            <h2>{{ $title }} <i class="material-icons">calendar_today</i></h2>
            <div class="row">
                <ul class="nav nav-tabs" id="myTab">
                    <li data-type="oneday" class="active"><a href="#">День</a></li>
                    <li data-type="fewdays"><a href="#">Промежуток</a></li>
                </ul>
                <div class="col-sm-12">
                    <input type="date" name="" class="form-control">
                </div>
            </div>
        </div>
    </div>
</div> 
<script>
    $(document).ready(function()
    {
        $('#myTab li').click(function (e) {
        e.preventDefault()
        $(this).tab('show')
        let type = $(this).data('type');
        // $.ajax({
        //     headers : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        //     dataType: "json",
        //     data: {type: type, pathname: pathname},
        //     url     : 'questions/selectByType',
        //     method    : 'post',
        //     success: function (response) {
        //         let result = '';
        //             for(var i = 0; i < response.length; i++) {
        //                 result += '<tr>';
        //                 result += '<td><a href="'+response[i]['path']+'/'+response[i]['id']+'">' + response[i]['block'] + '</td>';
        //                 result += '<td>' + response[i]['floor'] + '</td>';
        //                 result += '<td>' + response[i]['row'] + '</td>';
        //                 result += '<td>' + response[i]['place'] + '</td>';
        //                 result += '<td>' + response[i]['name'] + '</td>';
        //                 result += '<td>' + response[i]['phone'] + '</td>';
        //                 result += '</tr>';
        //             }
        //             $('tbody').html(result);
        //     },
        //     error: function (xhr, err) { 
        //         console.log(err + " " + xhr);
        //     }
        // });
    })

    });
</script>
@endsection