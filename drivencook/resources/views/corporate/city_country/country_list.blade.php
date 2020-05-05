@extends('corporate.layout_corporate')

@section('title')
    Gestion des pays
@endsection

@section('content')
    <div class="row">
        <div class="col-12 col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h2>Liste des pays</h2>
                </div>
                <div class="card-body">
                    <table id="all_countries" class="table table-hover table-striped table-bordered table-dark"
                           style="width: 100%">
                        <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Villes</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($country_list as $country)
                            <tr id="{{'row_'.$country['id']}}">
                                <td>{{$country['name']}}</td>
                                <td>
                                    <a href="{{route('city_list',['country_id'=>$country['id']])}}">
                                        {{trans('city.view_city_list')}}
                                    </a>
                                </td>
                                <td>
                                    <button onclick="onUpdateModal({{$country['id']}},'{{$country['name']}}')"
                                            class="fa fa-edit" data-toggle="modal"
                                            data-target="#formModal"></button>
                                    <button onclick="onDelete({{$country['id']}})"
                                            class="fa fa-trash ml-3"></button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <button type="button" onclick="onCreateModal()" class="btn btn-light_blue" data-toggle="modal"
                            data-target="#formModal">Ajouter
                    </button>
                </div>
            </div>
        </div>
    </div>
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
                            <label for="formCountryName">{{trans('city.country_name')}} :</label>
                            <input type="text" name="formCountryName" id="formCountryName"
                                   value=""
                                   maxlength="15"
                                   class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                        <button type="button" class="btn btn-primary" id="modalSubmit" onclick="onSubmit()">Save
                            changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#all_countries').DataTable();
        });

        function onCreateModal() {
            document.getElementById('modalTitle').innerText = 'Ajouter un pays';
            document.getElementById('modalSubmit').innerText = 'Ajouter';
            document.getElementById('formId').value = '';
            document.getElementById('formCountryName').value = '';
        }

        function onUpdateModal(id, name) {
            document.getElementById('modalTitle').innerText = 'Modifier un pays';
            document.getElementById('modalSubmit').innerText = 'Modifier';
            document.getElementById('formId').value = id;
            document.getElementById('formCountryName').value = name;
        }

        function onSubmit() {
            const id = document.getElementById('formId').value;
            const name = document.getElementById('formCountryName').value;
            if (!isNaN(id)) {
                $.ajax({
                    url: '{{route('country_submit')}}',
                    method: "post",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {'id': id, 'name': name},
                    success: function (data) {
                        const dataJ = JSON.parse(data);
                        if (dataJ.response === "success") {
                            let cityUrl = "{{route('city_list',['country_id'=> ':id'])}}";
                            cityUrl = cityUrl.replace(':id', dataJ.id);

                            if (dataJ.isNew === true) {
                                alert('Pays ajouté');
                                let tbody = document.getElementsByTagName('tbody')[0];
                                tbody.innerHTML =
                                    '<tr id="row_' + dataJ.id + '">' +
                                    '<td>' + dataJ.name + '</td>' +
                                    '<td>' +
                                    '<a href="' + cityUrl + '">{{trans('city.view_city_list')}}</a>' +
                                    '</td>' +
                                    '<td>' +
                                    '<button onclick="onUpdateModal(' + dataJ.id + ',' + dataJ.name + ')" class="fa fa-edit" data-toggle="modal" data-target="#formModal"></button>' +
                                    '<button onclick="onDelete(' + dataJ.id + ')" class="fa fa-trash ml-3"></button>' +
                                    '</td>' +
                                    '</tr>' + tbody.innerHTML;
                            } else {
                                alert('Pays modifié');
                                let row = document.getElementById('row_' + dataJ.id);
                                let nameTd = row.getElementsByTagName('td')[0];
                                nameTd.innerText = dataJ.name;
                            }
                            // $('#all_countries').DataTable().draw();
                            document.getElementById('closeModal').click();
                        } else {
                            alert("Une erreur est survenue, veuillez raffraichir la page");
                        }
                    },
                    error: function () {
                        alert("Une erreur est survenue, veuillez raffraichir la page");
                    }
                })
            }
        }

        function onDelete(id) {
            if (confirm("Voulez vous vraiment supprimer ce pays ?")) {
                if (!isNaN(id)) {
                    let urlB = '{{route('country_delete',['id'=>':id'])}}';
                    urlB = urlB.replace(':id', id);
                    $.ajax({
                        url: urlB,
                        method: "delete",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (data) {
                            if (data == id) {
                                alert("Pays supprimé");
                                let row = document.getElementById('row_' + id);
                                row.remove();
                            } else {
                                alert("Une erreur est survenue lors de la suppression, veuillez raffraichir la page");
                            }
                        },
                        error: function () {
                            alert("Une erreur est survenue lors de la suppression, veuillez raffraichir la page");
                        }
                    })

                }
            }
        }

    </script>
@endsection