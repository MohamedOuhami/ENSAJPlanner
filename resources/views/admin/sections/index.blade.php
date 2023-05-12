@extends('layouts.admin')
@section('content')
    <a class="btn btn-success mb-4" href="{{ route('admin.sections.create') }}">
        Ajouter une section
    </a>

    <a class="btn btn-success mb-4" href="{{ route('admin.sections.createauto') }}">
        Création automatique des sections
    </a>

    <a class="btn btn-danger mb-4" href="{{ route('admin.sections.cleargroups') }}">
        Vider les sections
    </a>



    <div class="card">
        <div class="card-header">
            Liste des sections
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-SchoolClass">
                    <thead>
                        <tr>
                            <th width="10">

                            </th>
                            <th>
                                Intitule
                            </th>
                            <th>
                                Semester
                            </th>
                            <th>
                                Modifier
                            </th>
                            <th>
                                Supprimer
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sections as $key => $section)
                            <tr data-entry-id="{{ $section->id }}">
                                <td>
                                    {{-- Leave It empty for the select checkboxes --}}
                                </td>

                                <td>
                                    {{ $section->Intitule ?? '' }}
                                </td>
                                <td>
                                    {{ $section->Semester ?? '' }}
                                </td>

                                <td>

                                    @can('school_class_edit')
                                        <a class="btn btn-xs btn-info" href="{{ route('admin.sections.edit', $section->id) }}">
                                            Modifier
                                        </a>
                                    @endcan

                                </td>

                                <td>

                                    @can('school_class_delete')
                                        <form action="{{ route('admin.sections.destroy', $section->id) }}" method="POST"
                                            onsubmit="return confirm('{{ trans('global.areYouSure') }}');"
                                            style="display: inline-block;">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <input type="submit" class="btn btn-xs btn-danger"
                                                value="Supprimer">
                                        </form>
                                    @endcan
                                </td>



                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    @parent
    <script>
        $(function() {
            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
            let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
            let deleteButton = {
                text: deleteButtonTrans,
                url: "{{ route('admin.sections.massDestroy') }}",
                className: 'btn-danger',
                action: function(e, dt, node, config) {
                    var ids = $.map(dt.rows({
                        selected: true
                    }).nodes(), function(entry) {
                        return $(entry).data('entry-id')
                    });

                    if (ids.length === 0) {
                        alert('{{ trans('global.datatables.zero_selected') }}')

                        return
                    }

                    if (confirm('{{ trans('global.areYouSure') }}')) {
                        $.ajax({
                                headers: {
                                    'x-csrf-token': _token
                                },
                                method: 'POST',
                                url: config.url,
                                data: {
                                    ids: ids,
                                    _method: 'DELETE'
                                }
                            })
                            .done(function() {
                                location.reload()
                            })
                    }
                }
            }
            dtButtons.push(deleteButton)

            $.extend(true, $.fn.dataTable.defaults, {
                order: [
                    [1, 'desc']
                ],
                pageLength: 100,
            });
            $('.datatable-SchoolClass:not(.ajaxTable)').DataTable({
                buttons: dtButtons
            })
            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });
        })
    </script>
@endsection
