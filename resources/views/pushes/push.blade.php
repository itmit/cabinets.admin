@extends('layouts.adminApp')

@section('content')

<div class="col-sm-12 tabs-content">
    <div class="row justify-content-center cont-m">
        <div class="col-md-12">
            <h2>{{ $title }}</h2>
            
            <div class="form-group{{ $errors->has('whom') ? ' has-error' : '' }}">
                <div class="col-xs-12 col-sm-2">
                <label for="whom" class="control-label text-tc">Push</label>
                </div>
        
                <div class="col-xs-12 col-sm-10">
                    <select name="whom" class="form-control type-change" required>
                        <option value="all" selected>Отправить всем</option>
                        <option value="cli">Выбрать клиента</option>
                    </select>
        
                    @if ($errors->has('whom'))
                        <span class="help-block">
                            <strong>{{ $errors->first('whom') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('client') ? ' has-error' : '' }} client" style="display: none">
                <div class="col-xs-12 col-sm-2">
                <label for="client" class="control-label text-tc">Клиент</label>
                </div>
        
                <div class="col-xs-12 col-sm-10">
                    <select name="client[]" class="form-control" required multiple>
                        <option value="" selected disabled>Клиент</option>
                        @foreach ($clients as $client)
                            <option value="{{ $client->id }}">{{ $client->name }}</option>
                        @endforeach
                    </select>
        
                    @if ($errors->has('client'))
                        <span class="help-block">
                            <strong>{{ $errors->first('client') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-12">
                    <button class="btn btn-primary">
                        Отправить
                    </button>
                </div>
            </div>

        </div>
    </div>
</div> 
<script>
    $(document).ready(function () {
        $(".type-change").change(function() {
            let type = $(this).val();
            if(type == 'all') $('.client').css('display', 'none');
            if(type == 'cli') $('.client').css('display', 'block');
        });

        $(".btn").click(function() {
            let type = $('select[name="whom"]').val();
            if(type == 'cli') let client = $('select[name="client[]"]').val();
            // if(type == 'all') $('.client').css('display', 'none');
            // if(type == 'cli') $('.client').css('display', 'block');
            console.log('type ' + type + ' client ' + client);
        });
    });
</script>
@endsection