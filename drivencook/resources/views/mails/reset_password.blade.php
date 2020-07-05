<!doctype html>
<html>
<head>
    <title>Drive'N'Cook - Nouveau mot de passe</title>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link href="{{asset('css/app.css')}}" rel="stylesheet">

</head>

<body>

<div class="container">
    @yield('content')
    {{ trans('mail.hello') }} {{$name}},<br>
    {{ trans('mail.reset_link_sent') }}

    <br>

    <a href="{{route('reset_password',['token'=>$token])}}">{{route('reset_password',['token'=>$token])}}</a>

    <br>

    <img src="https://dev.drivencook.fr/img/logo_transparent_2.png" alt="logo_drivencook" class="img-fluid mt-5"
         width="300">

    <h2 class="h2">{{ trans('mail.staff_signature') }}</h2>
</div>


<script type="text/javascript" src="/js/app.js"></script>

</body>
</html>