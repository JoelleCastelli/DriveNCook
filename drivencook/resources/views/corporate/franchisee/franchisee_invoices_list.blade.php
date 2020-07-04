@extends('corporate.layout_corporate')
@section('title')
    @php $pseudo = isset($franchisee['pseudo']['name']) ? " (".$franchisee['pseudo']['name'].")" : "" @endphp
    {{ ucfirst($franchisee['firstname']).' '.strtoupper($franchisee['lastname']).$pseudo }}
    - {{ trans('franchisee.invoices') }}
@endsection

@section('content')
    <div class="row">
        <div class="col-12 col-lg-12 mb-5">
            <div class="card">
                <div class="card-header">
                    <h2>{{ trans('franchisee.invoices') }}</h2>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="invoices" class="table table-hover table-striped table-bordered table-dark"
                               style="width: 100%">
                            <thead>
                            <tr>
                                <th>{{ trans('franchisee.invoice_emission_date') }}</th>
                                <th>{{ trans('franchisee.invoice_payment_date') }}</th>
                                <th>{{ trans('franchisee.invoice_amount') }}</th>
                                <th>{{ trans('franchisee.invoice_status') }}</th>
                                <th>{{ trans('franchisee.invoice_reference') }}</th>
                                <th>{{ trans('franchisee.invoice_type') }}</th>
                                <th>{{ trans('franchisee.actions') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($franchisee['invoices'] as $invoice)
                                <tr id="row_invoice_{{ $invoice['id'] }}">
                                    <td>
                                        {{ DateTime::createFromFormat('Y-m-d',$invoice['date_emitted'])->format('d/m/Y') }}
                                    </td>
                                    <td>
                                        {{ !empty($invoice['date_paid'])?
                                        DateTime::createFromFormat('Y-m-d', $invoice['date_paid'])->format('d/m/Y') : trans('franchisee.invoice_pending') }}
                                    </td>
                                    <td>{{ number_format($invoice['amount'], 2, ',', ' ').' €'}}</td>
                                    <td>{{ trans('franchisee.invoice_status_'.$invoice['status']) }}</td>
                                    <td>{{ $invoice['reference'] }}</td>
                                    <td>@if ($invoice['monthly_fee'] == 1)
                                            {{ trans('franchisee.invoice_monthly_fee') }}
                                        @elseif ($invoice['initial_fee'] == 1)
                                            {{ trans('franchisee.invoice_initial_fee') }}
                                        @elseif ($invoice['franchisee_order'] == 1)
                                            {{ trans('franchisee.invoice_restock') }}
                                        @endif</td>
                                    <td>
                                        <a class="ml-2 pdf_icon"
                                           href="{{ route('stream_franchisee_invoice',['id'=>$invoice['id']]) }}"
                                           target="_blank">
                                            <button class="text-light fa fa-file-pdf ml-2"></button>
                                        </a>

                                        <a class="ml-2 update_icon" onclick="on_edit_invoice({{ $invoice['id'] }})"
                                           data-toggle="modal" data-target="#invoice_modal">
                                            <button class="fa fa-edit ml-2"></button>
                                        </a>
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

    <!-- Modal -->
    <div class="modal fade" id="invoice_modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="form">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">{{ trans('franchisee.update_invoice_status') }}</h5>
                    <button type="button" id="closeModal" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form>
                    {{csrf_field()}}
                    <input type="hidden" id="invoice_id" name="invoice_id" value="">
                    <div class="modal-body">
                        <div id="update_invoice" class="form-group">
                            <label for="invoice_status">{{ trans('franchisee.select_invoice_status') }}</label>
                            <select class="form-control" id="invoice_status" name="invoice_status">
                                @foreach($invoices_status as $status)
                                    <option value="{{ $status }}" {{ $invoice['status'] == $status ? 'selected="selected"' : '' }}>
                                        {{ trans('franchisee.invoice_status_'.$status) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                                data-dismiss="modal">{{ trans('franchisee.cancel') }}</button>
                        <button type="button" class="btn btn-primary" id="modalSubmit"
                                onclick="on_submit()">{{ trans('franchisee.update') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        function on_edit_invoice(invoice_id, invoice_status) {
            document.getElementById('invoice_id').value = invoice_id;
            document.getElementById('invoice_status').value = invoice_status;
        }

        function on_submit() {
            const invoice_id = document.getElementById('invoice_id').value;
            const invoice_status = document.getElementById('invoice_status').value;
            if (!isNaN(invoice_id)) {
                let route = '{{ route('franchisee_invoice_status_update') }}';
                route = route.replace(':id', invoice_id);
                $.ajax({
                    url: route,
                    method: "post",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {'invoice_id': invoice_id, 'invoice_status': invoice_status},
                    success: function (data) {
                        const data_json = JSON.parse(data);
                        if (data_json.response === "success") {
                            document.getElementById('closeModal').click();
                            alert(Lang.get('franchisee.invoice_status_updated'));
                            let row = document.getElementById('row_invoice_' + invoice_id);
                            let status_td = row.getElementsByTagName('td')[3];
                            status_td.innerHTML = Lang.get('franchisee.invoice_status_' + invoice_status);
                            let actions_td = row.getElementsByTagName('td')[6];
                            let pdf_icon = row.getElementsByClassName('pdf_icon')[0];
                            pdf_icon.nextElementSibling.remove();
                            actions_td.innerHTML += '<a class="ml-2" onclick="on_edit_invoice(' + invoice_id + ')" ' +
                                'data-toggle="modal" data-target="#invoice_modal"> ' +
                                '<button  class="fa fa-edit ml-2"></button>' +
                                '</a>';
                        } else {
                            alert(Lang.get('franchisee.ajax_error'));
                        }
                    },
                    error: function () {
                        alert(Lang.get('franchisee.ajax_error'));
                    }
                })
            }
        }

        $(document).ready(function () {
            let table = $('#invoices').DataTable({searchPanes: true});
            table.searchPanes.container().prependTo(table.table().container());
        });
    </script>
@endsection
