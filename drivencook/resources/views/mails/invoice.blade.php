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
    {{ trans('mail.hello') }} {{$user['firstname'].' '.$user['lastname']}},<br>

    <p>
        Une facture a été généré sur ton compte !
    </p>
    <p>
        Tu peux la retrouver sur ton compte DriveNCook avec la référence : {{$invoice['reference']}}
    </p>

    <br><br>

    <img src="https://dev.drivencook.fr/img/logo_transparent_2.png" alt="logo_drivencook" class="img-fluid mt-5"
         width="400">

    <h2 class="h2">{{ trans('mail.staff_signature') }}</h2>
</div>


<script type="text/javascript" src="/js/app.js"></script>

</body>
</html>