<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Tradutor UL</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">
        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Arial', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-family: 'Nunito', sans-serif;
                font-size: 64px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>

    </head>
    <body>
        <div class="container-fluid">
            <div class="position-ref full-height">
                @if (Route::has('login'))
                    <div class="top-right links">
                        @auth
                            <a href="{{ url('/home') }}">Home</a>
                        @else
                            <a href="{{ route('login') }}">Login</a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}">Register</a>
                            @endif
                        @endauth
                    </div>
                @endif

                <div class="content">
                    <div class="title">
                        <a href="{{ route('index') }}" class="title">
                            Tradutor do Undead Legacy
                        </a>
                    </div>
                    <div class="row justify-content-md-center m-b-md">
                        <div class="col-md-auto bg-info p-3 m-3 rounded-3">
                            <div class="links">
                                <form action="{{ route('upload_localization') }}" enctype="multipart/form-data" method="post">
                                    @csrf
                                    <input type="file" name="file" type="Localization.txt" required> - <select name="tipo" required><option value="">--selecione--</option><option value="en">Ingles</option><option value="ptbr">Portugues</option></select> - <button type="submit" class="btn btn-sm btn-default">Enviar</button>
                                </form>
                            </div>
                        </div>
                        <div class="col-md-auto bg-info p-3 m-3 rounded-3">
                            <div class="links">
                                <form action="{{ route('buscar') }}" method="get">
                                    Buscar por: <input type="text" name="termo"> <button type="submit" class="btn btn-sm btn-default">Enviar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <table class="table table-striped table-hover">
                                @foreach ($localizations as $loc)
                                <tr>
                                    <form action="{{ route('salvar') }}" method="post">
                                        @csrf
                                        <input type="hidden" name="key" value="{{ $loc->key }}">
                                        <td style="width:15vw">
                                            {{ $loc->key }}
                                        </td>
                                        <td style="width:40vw">
                                            {{ $loc->english }}
                                        </td>
                                        <td style="width:40vw">
                                            <input type="text" name="brazilian" placeholder="Digite o texto para traduzir" style="width:100%" value="{{ old('brazilian', $loc->brazilian) }}">
                                        </td>
                                        <td style="width:5vw">
                                            <input type="button" value="{{ $loc->brazilian ? 'Traduzido' : 'traduzir' }}" class="btn btn-sm {{ $loc->brazilian ? 'btn-success' : 'btn-primary' }}" data-dbvalue="{{ old('brazilian', $loc->brazilian) }}">
                                        </td>
                                    </form>
                                </tr>
                                @endforeach
                            </table>
                            <div class="row justify-content-md-center">
                                <div class="col-md-auto">
                                    @if(strlen($termo))
                                    @php
                                        $localizations->appends(['termo' => $termo])
                                    @endphp
                                    @endif
                                    {!! $localizations->links() !!}
                                </div>
                            </div>
                            <div class="full-width text-center">Faltam {{ $faltam }} keys ({{ $traduzidos }}/{{ $faltam+$traduzidos }})</div>
                            <div class="full-width text-center"><a href="{{ route('exportCsv') }}">Download <strong>Localization.txt</strong></a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script>
$('input[type=button]').click(function() {
    var button = $(this);
    $.post(
        $(this.form).attr('action'),
        $(this.form).serialize(),
        function(data) {
            var db = jQuery.parseJSON(data);
            button.val('Traduzido').removeClass('btn-primary').addClass('btn-success').data('dbvalue', db.brazilian);
        }
    );
});
$('input[name="brazilian"]').keyup(function() {
    if ($(this).val() != $(this).parent().parent().find('input[type=button]').data('dbvalue')) {
        $(this).parent().parent().find('input[type=button]').val('Traduzir').removeClass('btn-success').addClass('btn-primary');
    } else {
        $(this).parent().parent().find('input[type=button]').val('Traduzido').removeClass('btn-primary').addClass('btn-success');
    }
});
</script>
