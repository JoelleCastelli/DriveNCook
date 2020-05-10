<!doctype html>
<html lang="fr">

    <head>
        <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
        <title>Drive 'N' Cook - Historique</title>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
    </head>

    <style>
        body { font: 14px Raleway, Sans-Serif; line-height: 19px;}
        #container { width: 700px; margin: 0 auto; }
        table { border-collapse: collapse; }
        table td, table th { border: 1px solid black; padding: 5px; }

        #header { height: 20px; width: 100%; margin: 20px 0; background: #222; text-align: center; color: white; font: bold 20px Raleway, Sans-Serif; text-decoration: uppercase; letter-spacing: 20px; padding: 8px 0px; }

        #address { height: 120px; float: left; }
        #dnc, #franchisee_name { font-size: 16px; font-weight: bold; }
        #logo { text-align: right; float: right; position: relative; }
        #image { width: 100px;}

        #history_info { margin-top: 1px; float: left; }
        #history_info td { text-align: right;  }
        #history_info td.history-head { text-align: left; background: #eee; }
        #franchisee { height: 100px; overflow: hidden; margin-bottom: 20px; }
        #franchisee-title { text-align: right; float: right; }

        #items { clear: both; width: 100%; margin: 30px 0 0 0; border: 1px solid black; }
        #items th, .order_total { background: #eee; }
        #items tr.item-row td { border: 0; }
        #items td.total-line { border-right: 0; text-align: right; padding-right: 20px; }
        #items td.total-value { border-left: 0; text-align: right; padding: 10px 20px 10px 10px;}
        #items td.final { background: #eee; }
        #items td.blank { border: 0; }

        .nb { text-align: right; padding-right: 10px;}
        .final, .order_total_text { text-align: right; }
        .final { font-weight: bold; }
    </style>

    <body>
        @php
            $history_total = 0;
            $history_quantity = 0;
            $nb_sales = 0;
        @endphp
        <div id="container">

            <div id="header">HISTORIQUE</div>

            <div id="company">

                <div id="address"><span id="dnc">Drive'N'Cook</span><br>
                    242 Rue du Faubourg Saint-Antoine<br>
                    75012 Paris<br>
                    01 56 06 90 41<br>
                    contact@drivencook.fr
                </div>

                <div id="logo">
                    <img id="image" src="{{ asset('img/logo_transparent.png') }}" alt="Logo Drive'N'Cook" />
                </div>

            </div>

            <div style="clear:both"></div>

            <div id="franchisee">

                <div id="franchisee-title">
                    <span id="franchisee_name">{{ $franchisee['firstname'] }} {{ $franchisee['lastname'] }}</span><br>
                    Pseudonyme : {{ $franchisee['pseudo'] ? $franchisee['pseudo']['name'] : 'aucun' }}<br>
                    ID franchisé : {{ $franchisee['id'] }}
                </div>

                <table id="history_info">
                    <tr>
                        <td class="history-head">Date de début</td>
                        <td>{{ DateTime::createFromFormat('Y-m-d', $start_date)->format('d/m/Y') }}</td>
                    </tr>
                    <tr>
                        <td class="history-head">Date de fin</td>
                        <td>{{ DateTime::createFromFormat('Y-m-d', $end_date)->format('d/m/Y') }}</td>
                    </tr>
                    <tr>
                        <td class="history-head">Nombre de ventes</td>
                        <td>{{ count($sales) }}</td>
                    </tr>
                </table>

            </div>

            <div style="clear:both"></div>

            <table id="items">
                
                <tr>
                    <th>Date</th>
                    <th>N° de vente</th>
                    <th>Méthode de paiement</th>
                    <th>Type de vente</th>
                    <th>Produit</th>
                    <th>Prix unitaire</th>
                    <th>Quantité</th>
                    <th>Total</th>
                </tr>

                @foreach($sales as $sale)
                    @if ($sale['date'] <= $end_date && $sale['date'] >= $start_date)
                        @php
                            $sale_quantity = 0;
                            $sale_total = 0;
                            $nb_sales += 1;
                        @endphp
                        @foreach($sale['sold_dishes'] as $sold_dish)
                            @php
                                $sale_quantity += $sold_dish['quantity'];
                                $history_quantity += $sold_dish['quantity'];
                                $dish_total = $sold_dish['unit_price'] * $sold_dish['quantity'];
                                $sale_total += $dish_total;
                                $history_total += $dish_total;
                            @endphp
                            <tr class="item-row">
                                <td>{{ DateTime::createFromFormat('Y-m-d', $sale['date'])->format('d/m/Y') }}</td>
                                <td class="nb">{{ $sale['id'] }}</td>
                                <td>{{ $sale['payment_method'] }}</td>
                                <td>{{ $sale['online_order'] == 1 ? 'En ligne' : 'Sur place' }}</td>
                                <td>{{ $sold_dish['dish']['name'] }}</td>
                                <td class="nb">{{ number_format($sold_dish['unit_price'], 2, ',', ' ') }} €</td>
                                <td class="nb">{{ $sold_dish['quantity'] }}</td>
                                <td class="nb">{{ number_format($dish_total, 2, ',', ' ') }} €</td>
                            </tr>
                        @endforeach
                            <tr class="order_total">
                                <td colspan="6" class="order_total_text">TOTAL DE LA VENTE</td>
                                <td colspan="1" class="nb">{{ $sale_quantity }}</td>
                                <td colspan="1" class="nb">{{ number_format($sale_total, 2, ',', ' ') }} €</td>
                            </tr>
                    @endif
                @endforeach

                <tr class="order_total final">
                    <td colspan="6" class="order_total_text">TOTAL DE L'HISTORIQUE</td>
                    <td colspan="1" class="nb">{{ $history_quantity }}</td>
                    <td colspan="1" class="nb">{{ number_format($history_total, 2, ',', ' ') }} €</td>
                </tr>

            </table>

        </div>

    </body>

    </html>
