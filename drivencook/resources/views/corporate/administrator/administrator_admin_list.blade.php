@extends('corporate.layout_corporate')
@section('title')
    {{ trans('administrator/user.title') }}
@endsection
@section('content')
    <div class="card mb-5">
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="card text-light2">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item bg-info">{{ trans('administrator/user.users_nb') }} : {{ count($users) }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card" id="client_list">
        <div class="card-header">
            <h2>{{ trans('administrator/user.users_section') }}</h2>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="allusers" class="table table-hover table-striped table-bordered table-dark"
                       style="width: 100%">
                    <thead>
                    <tr>
                        <th>{{ trans('administrator/global.actions') }}</th>
                        <th>{{ trans('administrator/user.name') }}</th>
                        <th>{{ trans('administrator/user.firstname') }}</th>
                        <th>{{ trans('administrator/user.phone') }}</th>
                        <th>{{ trans('administrator/user.email') }}</th>
                        <th>{{ trans('administrator/user.created_at') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                        <tr id="{{ 'row_'.$user['id'] }}">
                            <td>
                                <button onclick="deleteUser({{ $user['id'] }})"
                                        class="text-light fa fa-trash ml-2"></button>

                            </td>
                            <td>{{ $user['lastname'] }}</td>
                            <td>{{ $user['firstname'] }}</td>
                            <td>{{ $user['telephone'] }}</td>
                            <td>{{ $user['email'] }}</td>
                            <td>{{ $user['created_at'] }}</td>
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
            $('#allusers').DataTable();
        });

        function deleteUser(id) {
            if (confirm("Voulez-vous vraiment supprimer cet administrateur ? Toutes les données associées seront supprimées")) {
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
                                alert("Administrateur supprimé");
                                $('#allusers').DataTable().row('#row_' + id).remove().draw();
                            } else {
                                alert("Une erreur est survenue lors de la suppression, veuillez rafraîchir la page");
                            }
                        },
                        error: function () {
                            alert("Une erreur est survenue lors de la suppression, veuillez rafraîchir la page");
                        }
                    })
                }
            }
        }
    </script>
@endsection