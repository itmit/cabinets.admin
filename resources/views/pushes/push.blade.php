@extends('layouts.adminApp')

@section('content')

<div class="col-sm-12 tabs-content">
    <div class="row justify-content-center cont-m">
        <div class="col-md-12">
            <h2>{{ $title }}</h2>
            
            <div class="form-group{{ $errors->has('whom') ? ' has-error' : '' }}">
                <div class="col-xs-12 col-sm-2">
                <label for="whom" class="control-label text-tc">Кому</label>
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
                    <select name="client[]" class="form-control" required multiple size="{{ $clients->count() }}">
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

            <div class="form-group{{ $errors->has('text') ? ' has-error' : '' }}">
                <div class="col-xs-12 col-sm-2">
                <label for="text" class="control-label text-tc">Текст</label>
                </div>
        
                <div class="col-xs-12 col-sm-10">
                    <textarea name="text" class="form-control" cols="30" rows="10"></textarea>
        
                    @if ($errors->has('text'))
                        <span class="help-block">
                            <strong>{{ $errors->first('text') }}</strong>
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
            let clients = null;
            let text = $('textarea[name="text"]').val();
            if(type == 'cli')
            {
                clients = $('select[name="client[]"]').val();
            }
            if(type == null)
            {
                return false;
            }
            if(type == 'cli' && clients == null)
            {
                return false;
            }
            if(text == '' || text == null)
            {
                return false;
            }

            console.log(text);

            return false;

            $.ajax({
                headers : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                dataType: "json",
                data: {type: type, clients: clients},
                url     : 'sendPush',
                method    : 'post',
                success: function (response) {
                    if(clients == null) alert('Уведомления отправлены');
                    else
                    {
                        if(clients.length == 1) alert('Уведомление отправлено');
                        else alert('Уведомления отправлены');
                    }
                },
                error: function (xhr, err) { 
                    console.log(err + " " + xhr);
                }
            });
        });
    });
</script>
@endsection