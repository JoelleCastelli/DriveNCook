<!doctype html>
<html>
    <head>
        <title>Drive'N'Cook</title>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link href="{{asset('css/app.css')}}" rel="stylesheet">
    </head>

    <body>

        <div class="container">
            @yield('content')
            {{ trans('mail.hello') }},<br>

            <br>

            <p>To contact: </p>
            <p>     Email: {{ $user['email'] }}</p>
            <p>     Name: {{ $user['name'] }}</p>
            <p>     Message: </p>
            <p>            {{ $user['message'] }}</p>

            <br>

            <img src="https://dev.drivencook.fr/img/logo_transparent_2.png" alt="logo_drivencook" class="img-fluid mt-5"
                 width="300">

            <h2 class="h2">{{ trans('mail.staff_signature') }}</h2>
        </div>


        <script type="text/javascript" src="/js/app.js"></script>

    </body>
</html>