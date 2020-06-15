<!doctype html>
<html>
<head>
    <title>Drivencook</title>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link href="{{asset('css/app.css')}}" rel="stylesheet">

</head>

<body>

<div class="container">
    @yield('content')
    Bonjour {{$name}},<br>
    Un lien de réinitialisation de mot de passe pour votre compte a été généré, cliquez ci-dessous pour changer votre
    mot de passe :

    <br>

    <a href="{{route('reset_password',['token'=>$token])}}">{{route('reset_password',['token'=>$token])}}</a>

    <br>

    <img src="https://dev.drivencook.fr/img/logo_transparent_2.png" alt="logo_drivencook" class="img-fluid mt-5"
         style="max-width: 400px">

    <h2 class="h2">L'équipe Drive 'N' Cook</h2>
</div>


<script type="text/javascript" src="/js/app.js"></script>

</body>
</html>