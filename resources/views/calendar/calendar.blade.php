@extends('layouts.adminApp')

@section('content')

<div class="col-sm-12 tabs-content">
    <div class="row justify-content-center cont-m">
        <div class="col-md-12">
            <h2>{{ $title }} <i class="material-icons">calendar_today</i></h2>
            <div class="row">
                {{-- <ul class="nav nav-tabs" id="myTab">
                    <li data-type="oneday" class="active"><a href="#">День</a></li>
                    <li data-type="fewdays"><a href="#">Промежуток</a></li>
                </ul> --}}
                <div class="col-sm-12">
                    {{-- <div class="oneday" style="display: block">
                        <input type="date" name="onedaypick" class="form-control">
                    </div>
                    <div class="fewdays" style="display: none">
                        <div class="col-sm-6">
                            <input type="date" name="firstdaypick" class="form-control">
                        </div>
                        <div class="col-sm-6">
                            <input type="date" name="lastdaypick" class="form-control">
                        </div>
                    </div> --}}
                    <div class="col-sm-12 main">
                        {{-- <div class="list">
                            Для начала выберите дату!
                        </div> --}}
                        <iframe src="https://calendar.google.com/calendar/embed?height=600&amp;wkst=2&amp;bgcolor=%23ffffff&amp;ctz=Europe%2FMoscow&amp;src=Zm9uZG9vbXBzeUBnbWFpbC5jb20&amp;color=%23039BE5" style="border:solid 1px #777" width="800" height="600" frameborder="0" scrolling="no"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 
<script>
    // $(document).ready(function()
    // {
    //     $('#myTab li').click(function (e) {
    //         e.preventDefault();
    //         $(this).tab('show');
    //         let type = $(this).data('type');
    //         if(type == 'oneday')
    //         {
    //             $('.oneday').show();
    //             $('.fewdays').hide();
    //             $('input[name="onedaypick"]').val('');
    //             $('input[name="firstdaypick"]').val('');
    //             $('input[name="lastdaypick"]').val('');
    //             $('.list').html('Для начала выберите дату!');
    //         };
    //         if(type == 'fewdays')
    //         {
    //             $('.oneday').hide();
    //             $('.fewdays').show();
    //             $('input[name="onedaypick"]').val('');
    //             $('input[name="firstdaypick"]').val('');
    //             $('input[name="lastdaypick"]').val('');
    //             $('.list').html('Для начала выберите дату!');
    //         };
    //     });

    //     $('input[name="onedaypick"]').change(function () {
    //         date = $(this).val();
    //         $.ajax({
    //             headers : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
    //             dataType: "json",
    //             data: {date: date},
    //             url     : 'calendar/getOneDay',
    //             method    : 'post',
    //             success: function (response) {
    //                 // console.log(response);
    //                 let result = '';
    //                 for(var i = 0; i < response.length; i++) {
    //                     result += '<p>';
    //                     result += 'Кабинет <b><a href="/cabinets/'+response[i]['cabinet']['id']+'/edit">' + response[i]['cabinet']['name'] + '</a></b><i class="material-icons" style="color: '+response[i]['cabinet']['color']+'">home</i>';
    //                     result += '<ul>';
    //                     for(var y = 0; y < response[i]['reservations'].length; y++) {
    //                         result += '<li>';
    //                         result += 'Клиент <a href="/clients/'+response[i]['reservations'][y]['client']['id']+'">' + response[i]['reservations'][y]['client']['name'] + '</a>';
    //                         result += '<ul>';
    //                         for(var i0 = 0; i0 < response[i]['reservations'][y]['times'].length; i0++) {
    //                             result += '<li>';
    //                             result += response[i]['reservations'][y]['times'][i0]['time'];
    //                             result += '</li>';
    //                         }
    //                         result += '</ul>';
    //                         result += '</li>';
    //                     }
    //                     result += '</ul>';
    //                     result += '</p>';
    //                 }
    //                 $('.list').html(result);
    //             },
    //             error: function (xhr, err) { 
    //                 console.log(err + " " + xhr);
    //             }
    //         });
    //     });

    //     $('input[name="firstdaypick"]').change(function () {
    //         first_date = $(this).val();
    //         second_date = $('input[name="lastdaypick"]').val();
    //         $.ajax({
    //             headers : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
    //             dataType: "json",
    //             data: {first_date: first_date, second_date: second_date},
    //             url     : 'calendar/getFewDay',
    //             method    : 'post',
    //             success: function (response) {
    //                 // console.log(response);
    //                 let result = '';
    //                 for(var i = 0; i < response.length; i++) {
    //                     result += '<p>';
    //                     result += 'Кабинет <b><a href="/cabinets/'+response[i]['cabinet']['id']+'/edit">' + response[i]['cabinet']['name'] + '</a></b><i class="material-icons" style="color: '+response[i]['cabinet']['color']+'">home</i>';
    //                     result += '<ul>';
    //                     for(var y = 0; y < response[i]['reservations'].length; y++) {
    //                         result += '<li>';
    //                         result += 'Клиент <a href="/clients/'+response[i]['reservations'][y]['client']['id']+'">' + response[i]['reservations'][y]['client']['name'] + '</a> ('+response[i]['reservations'][y]['date']+')';
    //                         result += '<ul>';
    //                         for(var i0 = 0; i0 < response[i]['reservations'][y]['times'].length; i0++) {
    //                             result += '<li>';
    //                             result += response[i]['reservations'][y]['times'][i0]['time'];
    //                             result += '</li>';
    //                         }
    //                         result += '</ul>';
    //                         result += '</li>';
    //                     }
    //                     result += '</ul>';
    //                     result += '</p>';
    //                 }
    //                 $('.list').html(result);
    //             },
    //             error: function (xhr, err) { 
    //                 console.log(err + " " + xhr);
    //             }
    //         });
    //     });

    //     $('input[name="lastdaypick"]').change(function () {
    //         first_date = $('input[name="firstdaypick"]').val();
    //         second_date = $(this).val();
    //         $.ajax({
    //             headers : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
    //             dataType: "json",
    //             data: {first_date: first_date, second_date: second_date},
    //             url     : 'calendar/getFewDay',
    //             method    : 'post',
    //             success: function (response) {
    //                 // console.log(response);
    //                 let result = '';
    //                 for(var i = 0; i < response.length; i++) {
    //                     result += '<p>';
    //                     result += 'Кабинет <b><a href="/cabinets/'+response[i]['cabinet']['id']+'/edit">' + response[i]['cabinet']['name'] + '</a></b><i class="material-icons" style="color: '+response[i]['cabinet']['color']+'">home</i>';
    //                     result += '<ul>';
    //                     for(var y = 0; y < response[i]['reservations'].length; y++) {
    //                         result += '<li>';
    //                         result += 'Клиент <a href="/clients/'+response[i]['reservations'][y]['client']['id']+'">' + response[i]['reservations'][y]['client']['name'] + '</a> ('+response[i]['reservations'][y]['date']+')';
    //                         result += '<ul>';
    //                         for(var i0 = 0; i0 < response[i]['reservations'][y]['times'].length; i0++) {
    //                             result += '<li>';
    //                             result += response[i]['reservations'][y]['times'][i0]['time'];
    //                             result += '</li>';
    //                         }
    //                         result += '</ul>';
    //                         result += '</li>';
    //                     }
    //                     result += '</ul>';
    //                     result += '</p>';
    //                 }
    //                 $('.list').html(result);
    //             },
    //             error: function (xhr, err) { 
    //                 console.log(err + " " + xhr);
    //             }
    //         });
    //     });

    // });
</script>
@endsection