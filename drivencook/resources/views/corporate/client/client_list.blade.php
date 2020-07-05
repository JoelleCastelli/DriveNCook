@extends('corporate.layout_corporate')

@section('title')
    {{ trans('client/global.clients_management') }}
@endsection

@section('content')
    <div class="card mb-5">
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="card text-light2">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item bg-info">{{ trans('client/global.nb_clients') }} {{ count($client_list) }}</li>
                            <li class="list-group-item bg-info align-content-around">
                                <a href="#" class="row text-light2">
                                    <div class="col-10">
                                        {{ trans('client/global.view_details') }}
                                    </div>
                                    <div class="col-2">
                                        <i class="fa fa-chevron-right"></i>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="card text-light2">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item bg-indigo">{{ trans('client/global.month_nb_sales') }} {{ $month_sale_count }}</li>
                            <li class="list-group-item bg-indigo align-content-around">
                                <a href="#" class="row text-light2">
                                    <div class="col-10">
                                        {{ trans('client/global.view_details') }}
                                    </div>
                                    <div class="col-2">
                                        <i class="fa fa-chevron-right"></i>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="card text-light2">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item bg-success">{{ trans('client/global.nb_sales') }} {{ $total_sale_count }}</li>
                            <li class="list-group-item bg-success align-content-around">
                                <a href="#" class="row text-light2">
                                    <div class="col-10">
                                        {{ trans('client/global.view_details') }}
                                    </div>
                                    <div class="col-2">
                                        <i class="fa fa-chevron-right"></i>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-3">
                    <button class="btn btn-primary h-100 w-100" data-toggle="modal" data-target="#newsLetterModal">
                        <i class="fa fa-envelope mr-2"></i> {{ trans('client/global.send_newsletter') }}
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="card" id="client_list">
        <div class="card-header">
            <h2>{{ trans('client/global.clients_list') }}</h2>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="allclients" class="table table-hover table-striped table-bordered table-dark"
                       style="width: 100%">
                    <thead>
                        <tr>
                            <th>{{ trans('client/global.name') }}</th>
                            <th>{{ trans('client/global.firstname') }}</th>
                            <th>{{ trans('client/global.phone') }}</th>
                            <th>{{ trans('client/global.email') }}</th>
                            <th>{{ trans('client/global.registered_date') }}</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($client_list as $client)
                            <tr id="{{'row_'.$client['id']}}">
                                <td>{{ $client['lastname']}}</td>
                                <td>{{ $client['firstname']}}</td>
                                <td>{{ $client['telephone']}}</td>
                                <td>{{ $client['email']}}</td>
                                <td>{{DateTime::createFromFormat('Y-m-d H:i:s',$client['created_at'])->format('d/m/Y - H:i:s')}}</td>
                                <td>
                                    <a href="{{ route('client_view',['id'=>$client['id']]) }}">
                                        <button class="text-light fa fa-eye"></button>
                                    </a>
                                    <a class="ml-2" href="{{ route('client_update',['id'=>$client['id']]) }}">
                                        <button class="text-light fa fa-edit"></button>
                                    </a>
                                    <button onclick="deleteClient({{ $client['id']}})"
                                            class="text-light fa fa-trash ml-2"></button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
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
                    <form action="{{ route('send_client_newsletters') }}" method="post" class="p-2">

                        {{csrf_field() }}
                        <div class="form-group">
                            <p>{{ trans('client/global.newsletter_target') }}</p>
                            <div class="form-check" id="newsletter_type">
                                <input checked class="form-group form-check-input" type="radio" name="type" value="all"
                                       id="inlineRadio1" onclick="hideLoyaltyField()">
                                <label class="form-check-label"
                                       for="inlineRadio1">{{ trans('client/global.send_everybody') }}</label>
                            </div>
                            <div class="form-check" id="newsletter_type">
                                <input class="form-group form-check-input" type="radio" name="type" value="new"
                                       id="inlineRadio2"
                                       onclick="hideLoyaltyField()">
                                <label class="form-check-label"
                                       for="inlineRadio2">{{ trans('client/global.send_new_users') }}</label>
                            </div>
                            <div class="form-check" id="newsletter_type">
                                <input class="form-group form-check-input" type="radio" name="type" value="loyalty"
                                       id="inlineRadio3"
                                       onclick="showLoyaltyField()">
                                <label class="form-check-label"
                                       for="inlineRadio3">{{ trans('client/global.send_loyalty_points') }}</label>
                            </div>

                        </div>
                        <div class="form-group" id="loyalty_point_form" style="display: none">
                            <label for="loyalty_point">
                                {{ trans('client/global.minimum_loyalty_points') }}
                            </label>
                            <input class="form-control" name="loyalty_point" id="loyalty_point" type="number" min="0" value="0"
                                   step="1">
                        </div>

                        <div class="form-group">
                            <label for="news_message">{{ trans('client/global.optional_message') }}</label>
                            <textarea class="form-control" name="news_message" id="news_message" maxlength="255"></textarea>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('client/global.cancel') }}</button>
                            <button type="submit" class="btn btn-primary" id="modalSubmit">{{ trans('client/global.send') }}
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
            let table = $('#allclients').DataTable({searchPanes: true});
            //table.searchPanes.container().prependTo(table.table().container());
        });

        function hideLoyaltyField() {
            document.getElementById('loyalty_point_form').style.display = 'none';
        }

        function showLoyaltyField() {
            document.getElementById('loyalty_point_form').style.display = 'block';
        }

        function deleteClient(id) {
            if (confirm(Lang.get('client/global.delete_confirm'))) {
                if (!isNaN(id)) {
                    let urlB = '{{ route('client_delete', ['id'=>':id']) }}';
                    urlB = urlB.replace(':id', id);
                    $.ajax({
                        url: urlB,
                        method: "delete",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (data) {
                            if (data == id) {
                                alert(Lang.get('client/global.delete_success'));
                                $('#allclients').DataTable().row('#row_' + id).remove().draw();
                            } else {
                                alert(Lang.get('client/global.ajax_error'));
                            }
                        },
                        error: function () {
                            alert(Lang.get('client/global.ajax_error'));
                        }
                    })
                }
            }
        }
    </script>
@endsection