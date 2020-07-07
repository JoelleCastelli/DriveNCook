<!doctype html>
<html>
    <head>
        <title>{{ trans('mail.object_newsletter') }}</title>
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
                {{ trans('mail.newsletter_intro') }}
            </p>

            @if (!empty($user['client_orders_count']) && $user['client_orders_count'] > 0)
                <p>
                    {{ trans('mail.newsletter_orders', ['nb' => $user['client_orders_count']]) }}
                </p>
            @endif

            @if ($user['loyalty_point'] > 0 && !empty($fidelity))
                <p>
                    {{ trans('mail.newsletter_loyalty', ['nb' => $user['loyalty_point'], 'amount' => $fidelity]) }}
                </p>
            @endif

            @if (count($user['event_invited_30']) > 0 )
                <p>
                    {{ trans('mail.newsletter_events', ['nb' => $user['event_invited_30']]) }}
                <ul>
                    @foreach($user['event_invited_30'] as $event_invited)
                        <li>
                            {{$event_invited['event_30']['title'].' du '.$event_invited['event_30']['date_start'].' au '.$event_invited['event_30']['date_end']}}
                        </li>
                    @endforeach
                </ul>
                </p>
            @endif

            @if (!empty($newsMessage) && strlen($newsMessage) > 0)
                <p>
                    {{ trans('mail.newsletter_staff_message') }}<br>
                    {{$newsMessage}}
                </p>
            @endif

            <br><br>

            <img src="https://dev.drivencook.fr/img/logo_transparent_2.png" alt="logo_drivencook" class="img-fluid mt-5"
                 width="300">

            <h2 class="h2">{{ trans('mail.staff_signature') }}</h2>
        </div>


        <script type="text/javascript" src="/js/app.js"></script>

    </body>
</html>