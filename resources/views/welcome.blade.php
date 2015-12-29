<!DOCTYPE html>
<html>
<head>
    <title>GPUL Labs - Rexistro</title>

    <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{ asset('bootstrap/dist/css/bootstrap.min.css') }}"/>

    <style>
        html, body {
            height: 100%;
        }

        body {
            margin: 0;
            padding: 0;
            width: 100%;
            display: table;
            font-weight: 100;
            font-family: 'Lato';
        }

        .container {
            text-align: center;
            display: table-cell;
            vertical-align: middle;
        }

        .content {
            text-align: center;
            display: inline-block;
        }

        .title {
            font-size: 96px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="content">
        <div class="title">GPUL Labs.</div>

        <div class="text-center">
            <a href="{{ action("VolunteerController@welcome") }}" class="btn btn-primary">Rexístrate como voluntario
                aquí!</a>
        </div>
    </div>
    <div style="position: fixed; bottom: 20px; width:100%">
        <div class="col-lg-10 col-lg-offset-1">
            <p>Empregamos cookies de sesión para a entrada do usuario. Opcionalmente empregamos Piwik para manter unha
                analítica da web, pero podes evitar ser incluído no tratamento activando a opción
                <a href="https://en.wikipedia.org/wiki/Do_Not_Track" rel="nofollow">Do-Not-Track</a> do teu navegador.
            </p>
            <p>Creemos que esta é unha solución técnicamente posible e eficaz con arreglo á lei, xa que
                esta cookie pode ser denegada directamente polo usuario.</p>
        </div>
    </div>
</div>

@include('piwik')
</body>
</html>
