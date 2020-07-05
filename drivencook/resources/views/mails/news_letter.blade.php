<!doctype html>
<html>
<head>
    <title>Drive'N'Cook - Newsletter</title>
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
        Comment vas-tu ?<br>
        C'est le jour de notre petite newsletter rien que pour toi ! <br>
        Et il s'en est passé des choses...
    </p>

    @if (!empty($user['client_orders_count']) && $user['client_orders_count'] > 0)
        <p>
            Ce mois-ci, tu as passé {{$user['client_orders_count']}} commande(s) chez Drive'N'Cook !
        </p>
    @endif

    @if ($user['loyalty_point'] > 0 && !empty($fidelity))
        <p>
            Tu as à ce jour {{$user['loyalty_point']}} points de fidélités, ce qui te donne droit jusqu'à {{$fidelity}}€ de
            réduction sur ta prochaine commande.
        </p>
    @endif

    @if (count($user['event_invited_30']) > 0 )
        <p>
            Tu as été invité.e à {{count($user['event_invited_30'])}} évènement(s) privé(s) ces 30 derniers jours !
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
            Un petit message du staff :<br>
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