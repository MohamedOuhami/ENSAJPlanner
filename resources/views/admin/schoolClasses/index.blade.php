@extends('layouts.admin')
@section('content')
@can('school_class_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route("admin.school-classes.create") }}">
                Ajouter un élément
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        Liste des éléments
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
                            Volume Horaire ( Cours )
                        </th>
                        <th>
                            Volume Horaire ( TD )
                        </th>
                        <th>
                            Volume Horaire ( TP )
                        </th>
                        <th>
                            Occurence par semaine ( Cours )
                        </th>
                        <th>
                            Occurence par semaine ( TD )
                        </th>
                        <th>
                            Occurence par semaine ( TP )
                        </th>
                        <th>
                            Module
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
                    @foreach($schoolClasses as $key => $schoolClass)
                        <tr data-entry-id="{{ $schoolClass->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $schoolClass->name ?? '' }}
                            </td>
                            <td>
                                {{ $schoolClass->volume_horaire_Cours ?? '' }}
                            </td>
                            <td>
                                {{ $schoolClass->volume_horaire_TD ?? '' }}
                            </td>
                            <td>
                                {{ $schoolClass->volume_horaire_TP ?? '' }}
                            </td>
                            <td>
                                {{ $schoolClass->occ_per_week_Cours ?? '' }}
                            </td>
                            <td>
                                {{ $schoolClass->occ_per_week_TD ?? '' }}
                            </td>
                            <td>
                                {{ $schoolClass->occ_per_week_TP ?? '' }}
                            </td>
                            <td>
                                {{ $modules->firstWhere('id', $schoolClass->code_module)['intitule'] ?? '' }}
                            </td>
                            <td>

                                @can('school_class_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.school-classes.edit', $schoolClass->id) }}">
                                        Modifier
                                    </a>
                                @endcan

                            </td>
                            <td>

                                @can('school_class_delete')
                                    <form action="{{ route('admin.school-classes.destroy', $schoolClass->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger" value="Supprimer">
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
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('school_class_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.school-classes.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
      });

      if (ids.length === 0) {
        alert('{{ trans('global.datatables.zero_selected') }}')

        return
      }

      if (confirm('{{ trans('global.areYouSure') }}')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  dtButtons.push(deleteButton)
@endcan

  $.extend(true, $.fn.dataTable.defaults, {
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  $('.datatable-SchoolClass:not(.ajaxTable)').DataTable({ buttons: dtButtons })
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
})

</script>
@endsection