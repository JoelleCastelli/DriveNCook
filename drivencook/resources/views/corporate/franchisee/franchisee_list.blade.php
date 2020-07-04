@extends('corporate.layout_corporate')

@section('title')
    {{ trans('franchisee.franchisees_list') }}
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="card text-light2">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item bg-info">{{ trans('franchisee.total_franchisees').' '.count($franchisees)}}</li>
                            <li class="list-group-item bg-info align-content-arround">
                                <a href="#franchisee-list" class="row text-light2">
                                    <div class="col-10">
                                        {{ trans('franchisee.see_details') }}
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
                            <li class="list-group-item bg-indigo">{{ trans('franchisee.invoice_next_payment').' '.$nextPaiement }}</li>
                            <li class="list-group-item bg-indigo align-content-arround">
                                <a href="{{route('franchisee_obligation_update')}}" class="row text-light2">
                                    <div class="col-10">
                                        {{ trans('franchisee.see_details') }}
                                    </div>
                                    <div class="col-2">
                                        <i class="fa fa-chevron-right"></i>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card mt-5" id="franchisee-list">
        <div class="card-body">
            <div class="table-responsive">
                <table id="allfranchisees" class="table table-hover table-striped table-bordered table-dark"
                       style="width: 100%">
                    <thead>
                    <tr>
                        <th>{{ trans('franchisee.name') }}</th>
                        <th>{{ trans('franchisee.firstname') }}</th>
                        <th>{{ trans('franchisee.phone') }}</th>
                        <th>{{ trans('franchisee.email') }}</th>
                        <th>{{ trans('franchisee.pseudo') }}</th>
                        <th>{{ trans('franchisee.latest_monthly_payment') }}</th>
                        <th>{{ trans('franchisee.truck_location') }}</th>
                        <th>{{ trans('franchisee.registered_on') }}</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($franchisees as $franchisee)
                        <tr id="{{'row_'.$franchisee['id'] }}">
                            <td>{{ $franchisee['lastname'] }}</td>
                            <td>{{ $franchisee['firstname'] }}</td>
                            <td>{{ $franchisee['telephone'] }}</td>
                            <td>{{ $franchisee['email'] }}</td>
                            <td>{{ empty($franchisee['pseudo']) ? trans('franchisee.none') : $franchisee['pseudo']['name'] }}</td>

                            <td>{{ empty($franchisee['last_paid_invoice_fee']) ? trans('franchisee.never')
                                    :DateTime::createFromFormat('Y-m-d',$franchisee['last_paid_invoice_fee']['date_paid'])->format('d/m/Y') }}</td>

                            <td>{{ (empty($franchisee['truck']) ? trans('franchisee.no_truck_assigned') :
                                    (empty($franchisee['truck']['location']) ? trans('franchisee.not_specified_m') :
                                    $franchisee['truck']['location']['name'].' - '.$franchisee['truck']['location']['address']
                                    .' '.$franchisee['truck']['location']['postcode'].' '.$franchisee['truck']['location']['city'])) }}</td>

                            <td>{{ DateTime::createFromFormat('Y-m-d H:i:s',$franchisee['created_at'])->format('d/m/Y') }}</td>
                            <td>
                                <a href="{{route('franchisee_view',['id'=>$franchisee['id']])}}">
                                    <button class="text-light fa fa-eye"></button>
                                </a>
                                <a class="ml-2" href="{{route('franchisee_update',['id'=>$franchisee['id']])}}">
                                    <button class="text-light fa fa-edit"></button>
                                </a>
                                <button onclick="deleteFranchise({{ $franchisee['id'] }})"
                                        class="text-light fa fa-trash ml-2"></button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">

        $(document).ready(function () {
            let table = $('#allfranchisees').DataTable({searchPanes: true});
            table.searchPanes.container().prependTo(table.table().container());
        });

        function deleteFranchise(id) {
            if (confirm(Lang.get('franchisee.delete_confirm'))) {
                if (!isNaN(id)) {
                    let urlB = '{{ route('franchisee_delete',['id'=>':id']) }}';
                    urlB = urlB.replace(':id', id);
                    $.ajax({
                        url: urlB,
                        method: "delete",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (data) {
                            if (data == id) {
                                alert(Lang.get('franchisee.delete_success'));
                                $('#allfranchisees').DataTable().row('#row_' + id).remove().draw();
                            } else {
                                alert(Lang.get('franchisee.delete_error'));
                            }
                        },
                        error: function () {
                            alert(Lang.get('franchisee.delete_error'));
                        }
                    })
                }
            }
        }
    </script>
@endsection