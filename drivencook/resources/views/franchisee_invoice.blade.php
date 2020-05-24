<!doctype html>
<html lang="fr">

    <head>
        <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
        <title>Drive 'N' Cook - Facture</title>
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

        #invoice_info { margin-top: 1px; float: left; }
        #invoice_info td { text-align: right;  }
        #invoice_info td.invoice-head { text-align: left; background: #eee; }
        #franchisee { height: 100px; overflow: hidden; }
        #franchisee-title { text-align: right; float: right; }

        #items { clear: both; width: 100%; margin: 30px 0 0 0; border: 1px solid black; }
        #items th { background: #eee; }
        #items tr.item-row td { border: 0; }
        #items td.total-line { border-right: 0; text-align: right; padding-right: 20px; }
        #items td.total-value { border-left: 0; text-align: right; padding: 10px 20px 10px 10px;}
        #items td.ttc { background: #eee; }
        #items td.blank { border: 0; }

        .nb { text-align: right; padding-right: 20px;}
        .ttc { font-weight: bold;}

        #terms { text-align: center; margin: 20px 0 0 0; }
        #terms h5 { text-transform: uppercase; font: 13px Helvetica, Sans-Serif; letter-spacing: 5px; border-bottom: 1px solid black; padding: 0 0 8px 0; margin: 0 0 8px 0; }
        #terms div { width: 100%; text-align: center;}
    </style>

    @php
        $date = new DateTime($invoice['date_emitted']);
        $invoice_date = $date->format('d/m/Y');
        $end_date = $date->sub(new DateInterval('P1D'))->format('d/m/Y');
        $start_date = $date->sub(new DateInterval('P1M'))->format('d/m/Y');
    @endphp

    <body>
    
        <div id="container">

            <div id="header">FACTURE</div>

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
                    <span id="franchisee_name">{{ $invoice['user']['firstname'] }} {{ $invoice['user']['lastname'] }}</span><br>
                    Pseudonyme : {{ $pseudo ? $pseudo['name'] : 'aucun' }}<br>
                    ID franchisé : {{ $invoice['user']['id'] }}
                </div>

                <table id="invoice_info">
                    <tr>
                        <td class="invoice-head">Facture</td>
                        <td>{{ $invoice['reference'] }}</td>
                    </tr>
                    <tr>

                        <td class="invoice-head">Date</td>
                        <td>{{ $invoice_date }}</td>
                    </tr>
                </table>

            </div>

            <div style="clear:both"></div>

            <table id="items">

                <tr>
                    <th>Produit</th>
                    <th>Coût unitaire</th>
                    <th>Quantité</th>
                    <th>Prix</th>
                </tr>

                @if ($invoice['monthly_fee'] == 1)
                    <tr class="item-row">
                        <td>Redevance périodique pour la période
                            du {{ $start_date }}
                            au {{ $end_date }}</td>
                        <td class="nb">{{ number_format($invoice['amount'], 2, ',', ' ') }} €</td>
                        <td class="nb">1</td>
                        <td class="nb">{{ number_format($invoice['amount'], 2, ',', ' ') }} €</td>
                    </tr>
                @elseif ($invoice['initial_fee'] == 1)
                    <tr class="item-row">
                        <td>Redevance initiale forfaitaire</td>
                        <td class="nb">{{ number_format($invoice['amount'], 2, ',', ' ') }} €</td>
                        <td class="nb">1</td>
                        <td class="nb">{{ number_format($invoice['amount'], 2, ',', ' ') }} €</td>
                    </tr>
                @else
                    @for ($i = 0; $i < 10; $i++)
                        <tr class="item-row">
                            <td>Lasagnes</td>
                            <td class="nb">4 €</td>
                            <td class="nb">1</td>
                            <td class="nb">4 €</td>
                        </tr>
                    @endfor
                @endif

                <tr>
                    <td colspan="2" class="blank"></td>
                    <td colspan="1" class="total-line ttc">Total</td>
                    <td class="total-value ttc nb">{{ number_format($invoice['amount'], 2, ',', ' ') }} €</td>
                </tr>

            </table>

            <div id="terms">
                <h5>Conditions et modalités de paiement</h5>
                <div>Le paiement est dû dans les 15 jours suivant la date d'émission de la facture.<br><br>
                    Caisse d'Epargne <br>
                    IBAN : FR12 1234 5678<br>
                    BIC : ABCDFRPXXXX</div>
            </div>

        </div>

    </body>

    </html>
