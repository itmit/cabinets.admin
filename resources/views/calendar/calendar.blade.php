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
                    <div class="oneday" style="display: block">
                        <input type="date" name="onedaypick" class="form-control">
                    </div>
                    <div class="fewdays" style="display: none">
                        <div class="col-sm-6">
                            <input type="date" name="firstdaypick" class="form-control">
                        </div>
                        <div class="col-sm-6">
                            <input type="date" name="lastdaypick" class="form-control">
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <p>
                            Для начала выберите дату!
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 
<script>
    $(document).ready(function()
    {
        $('#myTab li').click(function (e) {
            e.preventDefault();
            $(this).tab('show');
            let type = $(this).data('type');
            if(type == 'oneday')
            {
                $('.oneday').show();
                $('.fewdays').hide();
            };
            if(type == 'fewdays')
            {
                $('.oneday').hide();
                $('.fewdays').show();
            };
        });

        $('input[name="onedaypick"]').change(function () {
            console.log($(this).val());
        });

    });
</script>
@endsection