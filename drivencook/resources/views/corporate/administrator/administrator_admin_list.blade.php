@extends('corporate.layout_corporate')
@section('title')
    {{ trans('admin.title') }}
@endsection
@section('content')
    <div class="card mb-5">
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="card text-light2">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item bg-info">{{ trans('admin.users_nb') }} : {{ count($users) }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card" id="client_list">
        <div class="card-header">
            <h2>{{ trans('admin.users_section') }}</h2>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="allusers" class="table table-hover table-striped table-bordered table-dark"
                       style="width: 100%">
                    <thead>
                        <tr>
                            <th>{{ trans('admin.name') }}</th>
                            <th>{{ trans('admin.firstname') }}</th>
                            <th>{{ trans('admin.phone') }}</th>
                            <th>{{ trans('admin.email') }}</th>
                            <th>{{ trans('admin.created_at') }}</th>
                            <th>{{ trans('administrator/global.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr id="{{ 'row_'.$user['id'] }}">
                                <td>{{ $user['lastname'] }}</td>
                                <td>{{ $user['firstname'] }}</td>
                                <td>{{ $user['telephone'] }}</td>
                                <td>{{ $user['email'] }}</td>
                                <td>{{ DateTime::createFromFormat('Y-m-d H:i:s', $user['created_at'])->format('d/m/Y') }}</td>
                                <td>
                                    @if($user['id'] != auth()->user()->id)
                                        <button onclick="deleteUser({{ $user['id'] }})"
                                                class="text-light fa fa-trash ml-2"></button>
                                    @endif
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
            let table = $('#allusers').DataTable({searchPanes: true});
            //table.searchPanes.container().prependTo(table.table().container());
        });

        function deleteUser(id) {
            if (confirm(Lang.get('admin.delete_confirm'))) {
                if (!isNaN(id)) {
                    let urlB = '{{ route('admin_delete', ['id'=>':id']) }}';
                    urlB = urlB.replace(':id', id);
                    $.ajax({
                        url: urlB,
                        method: "delete",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (data) {
                            if (data == id) {
                                alert(Lang.get('administrator/user.delete_success'));
                                $('#allusers').DataTable().row('#row_' + id).remove().draw();
                            } else {
                                alert(Lang.get('admin.ajax_error'));
                            }
                        },
                        error: function () {
                            alert(Lang.get('admin.ajax_error'));
                        }
                    })
                }
            }
        }
    </script>
@endsection