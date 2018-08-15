<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <a href="{{config('app.url')}}"><title>{{config('app.name')}}</title></a>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

</head>
<body class="container">
<div class="text-center m-5 p-5">
    <h1 class="display-1">{{config('app.name')}}</h1>
</div>
<div class="text-center">

    <h2 style="color: dodgerblue;">Votre demande a bien été prise en compte.</h2>

</div>
</body>
</html>
