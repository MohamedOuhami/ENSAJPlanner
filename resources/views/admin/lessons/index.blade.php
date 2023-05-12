@extends('layouts.admin')
@section('content')
    @can('lesson_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route('admin.lessons.storeauto', ['timetable_id' => $timetable_id]) }}">
                    Auto
                </a>
            </div>
        </div>
    @endcan
    <div class="card">
        <div class="card-header">
            Liste des séances
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-Lesson">
                    <thead>
                        <tr>
                            <th width="10">

                            </th>
                            <th>
                                Element
                            </th>
                            <th>
                                Type
                            </th>
                            <th>
                                Section / Groupe
                            </th>
                            <th>
                                Jour
                            </th>
                            <th>
                                Heure de depart
                            </th>
                            <th>
                                Heure de fin
                            </th>
                            <th>
                                Salle
                            </th>
                            <th>
                                Professeur
                            </th>
                            <th>
                                &nbsp;
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($lessons as $key => $lesson)
                            @php
                                $weekdays = [
                                    1 => 'Lundi',
                                    2 => 'Mardi',
                                    3 => 'Mercredi',
                                    4 => 'Jeudi',
                                    5 => 'Vendredi',
                                    6 => 'Samedi',
                                    7 => 'Dimanche',
                                ];
                            @endphp

                            <tr data-entry-id="{{ $lesson->id }}">
                                <td>

                                </td>
                                <td>
                                    {{ $lesson->matiere->name ?? '' }}
                                </td>
                                <td>
                                    {{ $lesson->type ?? '' }}
                                </td>
                                <td>
                                    @if ($lesson->type == 'Cours')
                                        {{ $lesson->timetable->section->Intitule }}
                                    @elseif ($lesson->type == 'TD')
                                        @php
                                            $lesson_group = \App\LessonGroup::where('lesson_id', $lesson->id)->first();
                                            $group_name = $lesson_group ? \App\Group::find($lesson_group->group_id)->intitule : null;
                                        @endphp
                                        {{ $group_name }}
                                    @elseif ($lesson->type == 'TP')
                                        {{ $lesson->timetable->section->Intitule }}
                                    @endif
                                </td>
                                <td>
                                    {{ $weekdays[$lesson->weekday] ?? '' }}
                                </td>
                                <td>
                                    {{ $lesson->start_time ?? '' }}
                                </td>
                                <td>
                                    {{ $lesson->end_time ?? '' }}
                                </td>
                                <td>
                                    {{ $lesson->salle->label ?? '' }}
                                </td>
                                <td>
                                    {{ $lesson->teacher->name ?? '' }}
                                </td>
                                <td>

                                    @can('school_class_create')
                                        <a class="btn btn-xs btn-primary"
                                            href="{{ route('admin.lessongroup.index', $lesson->id) }}">
                                            Designer groupes
                                        </a>
                                    @endcan

                                    @can('school_class_create')
                                        <a class="btn btn-xs btn-primary"
                                            href="{{ route('admin.lessonprofessors.create', $lesson->id) }}">
                                            Designer professeur
                                        </a>
                                    @endcan

                                    @can('lesson_show')
                                        <a class="btn btn-xs btn-primary"
                                            href="{{ route('admin.lessons.show', $lesson->id) }}">
                                            {{ trans('global.view') }}
                                        </a>
                                    @endcan

                                    @can('lesson_edit')
                                        <a class="btn btn-xs btn-info" href="{{ route('admin.lessons.edit', $lesson->id) }}">
                                            {{ trans('global.edit') }}
                                        </a>
                                    @endcan


                                    @can('lesson_delete')
                                        <form action="{{ route('admin.lessons.destroy', $lesson->id) }}" method="POST"
                                            onsubmit="return confirm('{{ trans('global.areYouSure') }}');"
                                            style="display: inline-block;">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <input type="submit" class="btn btn-xs btn-danger"
                                                value="{{ trans('global.delete') }}">
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
            @can('lesson_delete')
                let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
                let deleteButton = {
                    text: deleteButtonTrans,
                    url: "{{ route('admin.lessons.massDestroy') }}",
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
            @endcan

            $.extend(true, $.fn.dataTable.defaults, {
                order: [
                    [1, 'desc']
                ],
                pageLength: 100,
            });
            $('.datatable-Lesson:not(.ajaxTable)').DataTable({
                buttons: dtButtons
            })
            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });
        })
    </script>
@endsection
