@extends('layouts.admin')
@section('content')
@can('school_class_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.timetables.create') }}">
                Ajouter un emploi du temps
            </a>
            <a class="btn btn-info" href="{{ route('admin.timetableoptimizer.index')}}">
                Optimiser les emplois du temps
            </a>
            <a class="btn btn-info" href="{{route('admin.calendar.indexall')}}">
                Voir tous les séances des emplois du temps
            </a>
            
        </div>
    </div>

    @endcan

    <div class="card">
        <div class="card-header">
            Liste des emplois du temps
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-SchoolClass">
                    <thead>
                        <tr>
                            <th width="10">

                            </th>
                            <th>
                                Admin
                            </th>
                            <th>
                                Section
                            </th>
                            <th>
                                Nombre de semaines
                            </th>
                            <th>
                                Semestre
                            </th>

                            @can('lesson_create')
                                <th>
                                    Ajouter des seances
                                </th>
                            @endcan

                            @can('lesson_access')
                                <th>
                                    Voir séances
                                </th>
                            @endcan

                            @can('lesson_create')
                                <th>
                                    Voir emploi du temps
                                </th>
                            @endcan

                            @can('school_class_edit')
                                <th>
                                    Modifier
                                </th>
                            @endcan

                            @can('school_class_delete')
                                <th>
                                    Supprimer
                                </th>
                            @endcan
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($timetables as $key => $timetable)
                            <tr data-entry-id="{{ $timetable->id }}">
                                <td>
                                    {{-- Leave It empty for the select checkboxes --}}
                                </td>

                                <td>
                                    @php
                                        
                                        $user = App\User::find($timetable->admin_id);
                                    @endphp
                                    {{ $user->name ?? '' }}
                                </td>
                                <td>
                                    @php
                                        
                                        $section = App\Section::find($timetable->section_id);
                                    @endphp
                                    {{ $timetable->section->Intitule ?? '' }}
                                </td>
                                <td>
                                    
                                    {{ $timetable->nbr_weeks ?? '' }}
                                </td>
                                <td>
                                    
                                    {{ $section->Semester ?? '' }}
                                </td>

                                @can('lesson_create')
                                    <td>

                                        <a href="{{ route('admin.lessons.create', ['type' => 'Cours','id' => $timetable->id]) }}" class="btn btn-xs btn-success">
                                            Ajouter Cours
                                        </a>
                                        
                                        <a href="{{ route('admin.lessons.create', ['type' => 'TD','id' => $timetable->id]) }}" class="btn btn-xs btn-success">
                                            Ajouter TD
                                        </a>
                                        
                                        <a href="{{ route('admin.lessons.create', ['type' => 'TP','id' => $timetable->id]) }}" class="btn btn-xs btn-success">
                                            Ajouter TP
                                        </a>
                                        

                                    </td>
                                @endcan

                                @can('lesson_access')
                                    <td>

                                        <a class="btn btn-xs btn-info" href="{{ route('admin.lessons.index',['timetable_id' => $timetable->id]) }}">
                                            Voir seances
                                        </a>

                                    </td>
                                @endcan

                                @can('lesson_create')
                                    <td>

                                        <a class="btn btn-xs btn-info" href="{{route('admin.calendar.index',['timetable_id' => $timetable->id])}}">
                                            Voir emploi du temps
                                        </a>

                                    </td>
                                @endcan



                                @can('school_class_edit')
                                    <td>

                                        <a class="btn btn-xs btn-info"
                                            href="{{ route('admin.timetables.edit', $timetable ?? ('')->id) }}">
                                            Modifier
                                        </a>

                                    </td>
                                @endcan

                                @can('school_class_delete')
                                    <td>

                                        <form action="{{ route('admin.timetables.destroy', $timetable ?? ('')->id) }}"
                                            method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');"
                                            style="display: inline-block;">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <input type="submit" class="btn btn-xs btn-danger"
                                                value="Supprimer">
                                        </form>
                                    </td>
                                @endcan

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
                url: "{{ route('admin.school-classes.massDestroy') }}",
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
