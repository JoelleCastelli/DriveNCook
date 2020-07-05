@extends('corporate.layout_corporate')

@section('title')
    {{ trans('franchisee.pseudo_management') }}
@endsection

@section('content')
    <div class="row">
        <div class="col-12 col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h2>{{ trans('franchisee.pseudo_list') }}</h2>
                    <button type="button" onclick="onCreateModal()" class="btn btn-light_blue" data-toggle="modal"
                            data-target="#formModal">{{ trans('franchisee.add') }}
                    </button>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <table id="allpseudos" class="table table-hover table-striped table-bordered table-dark"
                                   style="width: 100%">
                                <thead>
                                <tr>
                                    <th>{{ trans('franchisee.pseudo') }}</th>
                                    <th>{{ trans('franchisee.availability') }}</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($pseudos as $pseudo)
                                        <tr id="{{'row_'.$pseudo['id']}}">
                                            <td>{{$pseudo['name']}}</td>
                                            <td>
                                                {{empty($pseudo['users'])?
                                                trans('franchisee.available') :
                                                trans('franchisee.unavailable_pseudo').$pseudo['users']['firstname'].' '.$pseudo['users']['lastname']}}
                                            </td>
                                            <td>
                                                <button onclick="onUpdateModal({{$pseudo['id']}},'{{$pseudo['name']}}')"
                                                        class="fa fa-edit" data-toggle="modal"
                                                        data-target="#formModal"></button>
                                                <button onclick="onDelete({{$pseudo['id']}})"
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
    </div>


    <!-- Modal -->
    <div class="modal fade" id="formModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="form">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Modal title</h5>
                    <button type="button" id="closeModal" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form>
                    {{csrf_field()}}
                    <input type="hidden" id="formId" name="id" value="">

                    <div class="modal-body">
                        <div class="form-group">
                            <label for="formPseudoName">{{ trans('franchisee.pseudo') }} :</label>
                            <input type="text" name="formPseudoName" id="formPseudoName"
                                   value="" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('franchisee.cancel') }}</button>
                        <button type="button" class="btn btn-primary" id="modalSubmit" onclick="onSubmit()">{{ trans('franchisee.submit') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">

        $(document).ready(function () {
            $('#allpseudos').DataTable();
        });

        function onCreateModal() {
            document.getElementById('modalTitle').innerText = Lang.get('franchisee.add_pseudo');
            document.getElementById('formId').value = '';
            document.getElementById('formPseudoName').value = '';
        }

        function onUpdateModal(id, name) {
            document.getElementById('modalTitle').innerText = Lang.get('franchisee.update_pseudo');
            document.getElementById('formId').value = id;
            document.getElementById('formPseudoName').value = name;
        }

        function onSubmit() {
            const id = document.getElementById('formId').value;
            const name = document.getElementById('formPseudoName').value;
            if (!isNaN(id)) {
                $.ajax({
                    url: '{{route('franchisee_pseudo_submit')}}',
                    method: "post",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {'id': id, 'name': name},
                    success: function (data) {
                        const dataJ = JSON.parse(data);
                        if (dataJ.response === "success") {
                            if (dataJ.isNew === true) {
                                document.getElementById('closeModal').click();
                                alert(Lang.get('franchisee.pseudo_created'));
                                let tbody = document.getElementsByTagName('tbody')[0];
                                tbody.innerHTML =
                                    '<tr id="row_' + dataJ.id + '">' +
                                    '<td>' + name + '</td>' +
                                    '<td>' + Lang.get('franchisee.available') +'</td>' +
                                    '<td>' +
                                    '<button onclick="onUpdateModal(' + dataJ.id + ', \'' + name + '\')" ' +
                                    'class="fa fa-edit" data-toggle="modal" data-target="#formModal"></button>' +
                                    '<button onclick="onDelete(' + dataJ.id + ')" class="fa fa-trash ml-3"></button> ' +
                                    '</td>' +
                                    '</tr>' + tbody.innerHTML;

                            } else {
                                document.getElementById('closeModal').click();
                                alert(Lang.get('franchisee.pseudo_updated'));
                                let row = document.getElementById('row_' + id);
                                let nameTd = row.getElementsByTagName('td')[0];
                                nameTd.innerText = name;
                            }
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

        function onDelete(id) {
            if (confirm(Lang.get('franchisee.confirm_pseudo_deletion'))) {
                if (!isNaN(id)) {
                    let urlB = '{{route('franchisee_pseudo_delete',['id'=>':id'])}}';
                    urlB = urlB.replace(':id', id);
                    $.ajax({
                        url: urlB,
                        method: "delete",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (data) {
                            if (data == id) {
                                alert(Lang.get('franchisee.pseudo_deleted'));
                                let row = document.getElementById('row_' + id);
                                row.remove();
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
        }
    </script>
@endsection