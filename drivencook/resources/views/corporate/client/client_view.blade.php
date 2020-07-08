@extends('corporate.layout_corporate')
@section('title')
    Client : {{ strtoupper($client['firstname'].' '.$client['lastname']) }}
@endsection

@section('content')
    <div class="row">
        <div class="col-12 col-lg-6 mb-5">
            <div class="card">
                <div class="card-header">
                    <h2>{{ trans('client/global.client_info') }}</h2>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><b>{{ trans('client/global.name') }} : </b>{{ $client['lastname'] }}
                    </li>
                    <li class="list-group-item"><b>{{ trans('client/global.firstname') }}
                            : </b>{{ $client['firstname'] }}</li>
                    <li class="list-group-item"><b>{{ trans('client/global.email') }} : </b>{{ $client['email'] }}</li>
                    <li class="list-group-item"><b>{{ trans('client/global.phone') }} :
                        </b>{{empty($client['telephone']) ? trans('client/global.not_specified_m') : $client['telephone'] }}
                    </li>
                    <li class="list-group-item"><b>{{ trans('client/global.birthdate') }} :
                        </b>{{empty($client['birthdate'])? trans('client/global.not_specified_f') :
                          DateTime::createFromFormat('Y-m-d',$client['birthdate'])->format('d/m/Y') }}
                    </li>
                    <li class="list-group-item"><b>{{ trans('client/global.registered_date') }} :
                        </b>{{empty($client['created_at'])?trans('client/global.not_specified_f'):
                          DateTime::createFromFormat('Y-m-d H:i:s',$client['created_at'])->format('d/m/Y à H\hi') }}
                    </li>
                </ul>
                <div class="card-footer">
                    <a href="{{route('client_update',['id'=>$client['id']]) }}">
                        <button class="btn btn-light_blue">{{ trans('client/global.update') }}</button>
                    </a>
                    <button class="btn btn-primary ml-2" data-toggle="modal" data-target="#newsLetterModal">
                        <i class="fa fa-envelope mr-2"></i> {{ trans('client/global.send_newsletter') }}
                    </button>

                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-lg-12 mb-5">
            <div class="card">
                <div class="card-header">
                    <h2>{{ trans('client/global.client_orders') }}</h2>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="client_orders" class="table table-hover table-striped table-bordered table-dark"
                               style="width: 100%">
                            <thead>
                            <tr>
                                <th>{{ trans('client/global.order_date') }}</th>
                                <th>{{ trans('client/global.order_online') }}</th>
                                <th>{{ trans('client/global.payment_method') }}</th>
                                <th>{{ trans('client/global.order_content') }}</th>
                                <th>Total</th>
                                <th>{{ trans('client/global.franchisee') }}</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($client_orders as $order)
                                <tr id="row_{{$order['id']}}">
                                    <td>
                                        {{ DateTime::createFromFormat('Y-m-d',$order['date'])->format('d/m/Y') }}
                                    </td>
                                    <td>{{ $order['online_order']? trans('client/global.yes') : trans('client/global.no') }}</td>
                                    <td>{{ $order['payment_method'] }}</td>
                                    <td>
                                        <?php
                                        $str = '';
                                        foreach ($order['sold_dishes'] as $sold_dish) {
                                            $str .= $sold_dish['quantity'] . ' x ' . $sold_dish['dish']['name'] . "<br>";
                                        }
                                        echo $str;
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        $total = 0;
                                        foreach ($order['sold_dishes'] as $sold_dish) {
                                            $total += $sold_dish['quantity'] * $sold_dish['unit_price'];
                                        }
                                        echo $total . ' €';
                                        ?>
                                    </td>
                                    <td>
                                        <a href="{{route('franchisee_view',['id'=>$order['user_franchised']['id']]) }}">
                                            <i class="fa text-light fa-eye"></i>
                                        </a>
                                        {{ $order['user_franchised']['pseudo']['name'] }}
                                    </td>
                                    <td>
                                        <a href="{{route('corporate.view_client_sale',['sale_id'=>$order['id']])}}">
                                            <i class="fa fa-eye text-light"></i>
                                        </a>
                                        <button onclick="deleteEvent({{$order['id']}})"
                                                class="fa fa-trash ml-3"></button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="newsLetterModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="form">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">{{ trans('client/global.send_newsletter') }}</h5>
                    <button type="button" id="closeModal" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{route('send_client_newsletters_unique') }}" method="post" class="p-2">

                        {{csrf_field() }}

                        <input type="hidden" id="user_id" name="user_id" value="{{ $client['id'] }}">

                        <div class="form-group">
                            <label for="news_message">{{trans('client/global.optional_message') }}</label>
                            <textarea class="form-control" name="news_message" id="news_message"
                                      maxlength="255"></textarea>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"
                                    data-dismiss="modal">{{ trans('client/global.cancel') }}</button>
                            <button type="submit" class="btn btn-primary"
                                    id="modalSubmit">{{ trans('client/global.send') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#client_orders').DataTable();
        });

        function deleteEvent(sale_id) {
            if (confirm(Lang.get('sale.delete_confirm'))) {
                if (!isNaN(sale_id)) {
                    let urlB = '{{route('corporate.delete_client_sale',['sale_id'=>':id'])}}';
                    urlB = urlB.replace(':id', sale_id);
                    $.ajax({
                        url: urlB,
                        method: "delete",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (data) {
                            if (data == sale_id) {
                                alert(Lang.get('client.sale.delete_success'));
                                $('#client_orders').DataTable().row('#row_' + sale_id).remove().draw();
                            } else {
                                alert(Lang.get('event.ajax_error'));
                            }
                        },
                        error: function () {
                            alert(Lang.get('event.ajax_error'));
                        }
                    })
                }
            }
        }

    </script>
@endsection
