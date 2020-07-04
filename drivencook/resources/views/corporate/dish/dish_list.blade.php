@extends('corporate.layout_corporate')

@section('title')
    Catalogue
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                @foreach($stats_categories as $stat_name => $stat_value)
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="card text-light2">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item bg-info">{{ trans('dish.stat_'.$stat_name) }} {{ $stat_value }} {{ trans_choice('dish.products', $stat_value) }}</li>
                            </ul>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="row">
                @foreach($stats_diets as $stat_name => $stat_value)
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="card text-light2">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item bg-indigo">{{ trans('dish.stat_'.$stat_name) }} {{ $stat_value }} {{ trans_choice('dish.products', $stat_value) }}</li>
                            </ul>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="card mt-5" id="dishes-list">
        <div class="card-body">
            <div class="table-responsive">
                <table id="all_dishes" class="table table-hover table-striped table-bordered table-dark"
                       style="width: 100%">
                    <thead>
                        <tr>
                            <th>{{ trans('dish.name') }}</th>
                            <th>{{ trans('dish.category') }}</th>
                            <th>{{ trans('dish.description') }}</th>
                            <th>{{ trans('dish.diet') }}</th>
                            <th>{{ trans('dish.actions') }}</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($dishes as $dish)
                            <tr id="{{'row_'.$dish['id'] }}">
                                <td>{{ $dish['name'] }}</td>
                                <td>{{ trans('dish.category_'.strtolower($dish['category'])) }}</td>
                                <td>{{ $dish['description'] }}</td>
                                <td>{{ trans('dish.diet_'.strtolower($dish['diet'])) }}</td>
                                <td>
                                    <a class="ml-2" href="{{route('dish_update', ['id' => $dish['id']]) }}">
                                        <button class="text-light fa fa-edit" title="{{ trans('dish.update_dish') }}"></button>
                                    </a>
                                    <button onclick="deleteDish({{ $dish['id'] }})"
                                            class="text-light fa fa-trash ml-2" title="{{ trans('dish.delete_dish') }}"></button>
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
            let table = $('#all_dishes').DataTable({searchPane: true});
            table.searchPanes.container().prependTo(table.table().container());
        });

        function deleteDish(id) {
            if (confirm(Lang.get('dish.delete_confirm'))) {
                if (!isNaN(id)) {
                    let url_delete = '{{ route('dish_delete',['id'=>':id']) }}';
                    url_delete = url_delete.replace(':id', id);
                    $.ajax({
                        url: url_delete,
                        method: "delete",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (data) {
                            if (data == id) {
                                alert(Lang.get('dish.delete_success'));
                                $('#all_dishes').DataTable().row('#row_' + id).remove().draw();
                            } else {
                                alert(Lang.get('dish.delete_error'));
                            }
                        },
                        error: function () {
                            alert(Lang.get('dish.delete_error'));
                        }
                    })
                }
            }
        }
    </script>
@endsection