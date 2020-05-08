@extends('corporate.layout_corporate')

@section('title')
    Gestion des emplacements camions
@endsection

@section('content')
    <div class="row">
        <div class="col-12 col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h2>Liste des emplacements camions</h2>
                </div>
                <div class="card-body">
                    <table id="all_locations" class="table table-hover table-striped table-bordered table-dark"
                           style="width: 100%">
                        <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Adresse</th>
                            <th>Ville</th>
                            <th>Pays</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($location_list as $location)
                            <tr id="{{'row_'.$location['id']}}">
                                <td>{{$location['name']}}</td>
                                <td>{{$location['address']}}</td>
                                <td>{{empty($location['city'])?'Non renseigné':$location['city']['name'].' ('.$location['city']['postcode'].')'}}</td>
                                <td>{{empty($location['city']['country'])?'Non renseigné':$location['city']['country']['name']}}</td>
                                <td>
                                    <button onclick="onUpdateModal('{{$location['id']}}','{{$location['name']}}','{{$location['address']}}','{{$location['city_id']}}')"
                                            class="fa fa-edit" data-toggle="modal"
                                            data-target="#formModal"></button>
                                    <button onclick="onDelete({{$location['id']}})"
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
                            <label for="formLocationName">{{trans('location.location_name')}} :</label>
                            <input type="text" name="formLocationName" id="formLocationName"
                                   value=""
                                   minlength="1"
                                   maxlength="30"
                                   class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="formLocationAddress">{{trans('location.location_address')}} :</label>
                            <input type="text" name="formLocationAddress" id="formLocationAddress"
                                   value=""
                                   minlength="1"
                                   maxlength="100"
                                   class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="formLocationCity">{{trans('city.city_name')}} :</label>
                            <select type="text" name="formLocationCity" id="formLocationCity" class="form-control"
                                    required>
                                @foreach ($city_list as $city)
                                    <option value="{{$city['id']}}">{{$city['country']['name'].' - '.$city['name']}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                        <button type="button" class="btn btn-primary" id="modalSubmit" onclick="onSubmit()">Save changes
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
            $('#all_locations').DataTable();
        });

        function onCreateModal() {
            document.getElementById('modalTitle').innerText = 'Ajouter un emplacement';
            document.getElementById('modalSubmit').innerText = 'Ajouter';
            document.getElementById('formId').value = '';
            document.getElementById('formLocationName').value = '';
            document.getElementById('formLocationAddress').value = '';
            document.getElementById('formLocationCity').value = '';
        }

        function onUpdateModal(id, name, address, city_id) {
            document.getElementById('modalTitle').innerText = 'Modifier un emplacement';
            document.getElementById('modalSubmit').innerText = 'Modifier';
            document.getElementById('formId').value = id;
            document.getElementById('formLocationName').value = name;
            document.getElementById('formLocationAddress').value = address;
            document.getElementById('formLocationCity').value = city_id;
        }

        function onSubmit() {
            const id = document.getElementById('formId').value;
            const name = document.getElementById('formLocationName').value;
            const address = document.getElementById('formLocationAddress').value;
            const city_id = document.getElementById('formLocationCity').value;

            if (!isNaN(id)) {
                $.ajax({
                    url: '{{route('location_submit')}}',
                    method: "post",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {'id': id, 'name': name, 'address': address, 'city_id': city_id},
                    success: function (data) {
                        const dataJ = JSON.parse(data);
                        if (dataJ.response === "success") {
                            if (dataJ.isNew === true) {
                                alert('Emplacement ajouté');
                                let tbody = document.getElementsByTagName('tbody')[0];
                                tbody.innerHTML =
                                    '<tr id="row_' + dataJ.id + '">' +
                                    '<td>' + dataJ.name + '</td>' +
                                    '<td>' + dataJ.address + '</td>' +
                                    '<td>' + dataJ.city + '</td>' +
                                    '<td>' + dataJ.country + '</td>' +
                                    '<td>' +
                                    '<button onclick="onUpdateModal(' + dataJ.id + ',' + dataJ.name + ',' + dataJ.address + ',' + dataJ.city_id + ')" class="fa fa-edit" data-toggle="modal" data-target="#formModal"></button>' +
                                    '<button onclick="onDelete(' + dataJ.id + ')" class="fa fa-trash ml-3"></button>' +
                                    '</td>' +
                                    '</tr>' + tbody.innerHTML;
                            } else {
                                alert('Emplacement modifié');
                                let row = document.getElementById('row_' + dataJ.id);
                                let nameTd = row.getElementsByTagName('td')[0];
                                let addressTd = row.getElementsByTagName('td')[1];
                                let cityTd = row.getElementsByTagName('td')[2];
                                let countryTd = row.getElementsByTagName('td')[3];
                                nameTd.innerText = dataJ.name;
                                addressTd.innerText = dataJ.address;
                                cityTd.innerText = dataJ.city;
                                countryTd.innerText = dataJ.country;
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
            if (confirm("Voulez vous vraiment supprimer cet emplacement ?")) {
                if (!isNaN(id)) {
                    let urlB = '{{route('location_delete',['id'=>':id'])}}';
                    urlB = urlB.replace(':id', id);
                    $.ajax({
                        url: urlB,
                        method: "delete",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (data) {
                            if (data == id) {
                                alert("Emplacement supprimé");
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