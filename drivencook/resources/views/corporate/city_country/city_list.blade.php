@extends('corporate.layout_corporate')

@section('title')
    Gestion des villes du pays "{{$country['name']}}"
@endsection

@section('content')
    <div class="row">
        <div class="col-12 col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h2>Liste des villes</h2>
                </div>
                <div class="card-body">
                    <table id="all_countries" class="table table-hover table-striped table-bordered table-dark"
                           style="width: 100%">
                        <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Code postal</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($city_list as $city)
                            <tr id="{{'row_'.$city['id']}}">
                                <td>{{$city['name']}}</td>
                                <td>{{$city['postcode']}}</td>
                                <td>
                                    <button onclick="onUpdateModal({{$city['id']}},'{{$city['name']}}','{{$city['postcode']}}')"
                                            class="fa fa-edit" data-toggle="modal"
                                            data-target="#formModal"></button>
                                    <button onclick="onDelete({{$city['id']}})"
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
                            <label for="formCityName">{{trans('city.city_name')}} :</label>
                            <input type="text" name="formCityName" id="formCityName"
                                   value=""
                                   maxlength="15"
                                   class="form-control">
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="formCityPostcode">{{trans('city.postcode')}} :</label>
                            <input type="number" name="formCityPostcode" id="formCityPostcode"
                                   value=""
                                   min="10000"
                                   max="99999"
                                   step="1"
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
            document.getElementById('modalTitle').innerText = 'Ajouter une ville';
            document.getElementById('modalSubmit').innerText = 'Ajouter';
            document.getElementById('formId').value = '';
            document.getElementById('formCityName').value = '';
            document.getElementById('formCityPostcode').value = '';
        }

        function onUpdateModal(id, name, postcode) {
            document.getElementById('modalTitle').innerText = 'Modifier une ville';
            document.getElementById('modalSubmit').innerText = 'Modifier';
            document.getElementById('formId').value = id;
            document.getElementById('formCityName').value = name;
            document.getElementById('formCityPostcode').value = postcode;
        }

        function onSubmit() {
            const id = document.getElementById('formId').value;
            const name = document.getElementById('formCityName').value;
            const postcode = document.getElementById('formCityPostcode').value;
            const country_id = "{{$country['id']}}";

            if (!isNaN(id)) {
                $.ajax({
                    url: '{{route('city_submit')}}',
                    method: "post",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {'id': id, 'name': name, 'postcode': postcode, 'country_id': country_id},
                    success: function (data) {
                        const dataJ = JSON.parse(data);
                        if (dataJ.response === "success") {
                            if (dataJ.isNew === true) {
                                alert('Ville ajoutée');
                                let tbody = document.getElementsByTagName('tbody')[0];
                                tbody.innerHTML =
                                    '<tr id="row_' + dataJ.id + '">' +
                                    '<td>' + dataJ.name + '</td>' +
                                    '<td>' + dataJ.postcode + '<td>' +
                                    '<button onclick="onUpdateModal(' + dataJ.id + ',' + dataJ.name + ',' + dataJ.postcode + ')" class="fa fa-edit" data-toggle="modal" data-target="#formModal"></button>' +
                                    '<button onclick="onDelete(' + dataJ.id + ')" class="fa fa-trash ml-3"></button>' +
                                    '</td>' +
                                    '</tr>' + tbody.innerHTML;
                            } else {
                                alert('Ville modifiée');
                                let row = document.getElementById('row_' + dataJ.id);
                                let nameTd = row.getElementsByTagName('td')[0];
                                let postcodeTd = row.getElementsByTagName('td')[1];
                                nameTd.innerText = dataJ.name;
                                postcodeTd.innerText = dataJ.postcode;
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
            if (confirm("Voulez vous vraiment supprimer cette ville ?")) {
                if (!isNaN(id)) {
                    let urlB = '{{route('city_delete',['id'=>':id'])}}';
                    urlB = urlB.replace(':id', id);
                    $.ajax({
                        url: urlB,
                        method: "delete",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (data) {
                            if (data == id) {
                                alert("Ville supprimée");
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