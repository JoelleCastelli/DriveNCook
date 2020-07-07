<!doctype html>
<html>
    <head>
        <title>{{ trans('mail.object_event_invitation') }}</title>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
    </head>

    <body>

        <div class="container">
            @yield('content')
            {{ trans('mail.hello') }} {{$name}},<br>

            {{ trans('mail.event_header') }}

            <h2 class="h2">{{$title}}</h2>

            {{ trans('mail.event_description', ['begin' => $begin, 'end' => $end, 'address' => $address ]) }}

            <br><br>

            {{$description}}
            <br>
            {{ trans('mail.event_end') }}
            <br><br>

            <img src="https://dev.drivencook.fr/img/logo_transparent_2.png" alt="logo_drivencook" class="img-fluid mt-5"
                 width="300">

            <h2 class="h2">{{ trans('mail.staff_signature') }}</h2>
        </div>


        <script type="text/javascript" src="/js/app.js"></script>

    </body>
</html>