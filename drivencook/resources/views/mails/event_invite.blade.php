<!doctype html>
<html>
<head>
    <title>Drivencook événement</title>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>

<body>

<div class="container">
    @yield('content')
    {{ trans('mail.hello') }} {{$name}},<br>

    Tu as été invité à un événement !

    <h2 class="h2">{{$title}} :</h2>

    Cet événement aura lieu du {{$begin}} au {{$end}} à l'adresse : {{$address}}

    <br><br>

    {{$description}}
    <br>
    Tu peux dès à présent suivre cet évènement en te connectant à ton compte !
    <br><br>

    <img src="https://dev.drivencook.fr/img/logo_transparent_2.png" alt="logo_drivencook" class="img-fluid mt-5"
         width="400">

    <h2 class="h2">{{ trans('mail.staff_signature') }}</h2>
</div>


<script type="text/javascript" src="/js/app.js"></script>

</body>
</html>