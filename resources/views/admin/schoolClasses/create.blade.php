@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            Ajouter un element
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('admin.school-classes.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label class="required" for="name">Intitule</label>
                    <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name"
                        id="name" value="{{ old('name', '') }}" required>
                    @if ($errors->has('name'))
                        <div class="invalid-feedback">
                            {{ $errors->first('name') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.schoolClass.fields.name_helper') }}</span>
                </div>

                <div class="form-group">
                    <label class="required" for="volume_horaire_Cours">Volume Horaire ( Cours )</label>
                    <input class="form-control {{ $errors->has('volume_horaire_Cours') ? 'is-invalid' : '' }}" type="number" name="volume_horaire_Cours"
                        id="volume_horaire_Cours" value="{{ old('volume_horaire_Cours', '') }}" required>
                    <span class="help-block">{{ trans('cruds.schoolClass.fields.name_helper') }}</span>
                </div>

                <div class="form-group">
                    <label class="required" for="volume_horaire_TD">Volume Horaire ( TD )</label>
                    <input class="form-control {{ $errors->has('volume_horaire_TD') ? 'is-invalid' : '' }}" type="number" name="volume_horaire_TD"
                        id="volume_horaire_TD" value="{{ old('volume_horaire_TD', '') }}" required>
                    <span class="help-block">{{ trans('cruds.schoolClass.fields.name_helper') }}</span>
                </div>

                <div class="form-group">
                    <label class="required" for="volume_horaire_TP">Volume Horaire ( TP )</label>
                    <input class="form-control {{ $errors->has('volume_horaire_TP') ? 'is-invalid' : '' }}" type="number" name="volume_horaire_TP"
                        id="volume_horaire_Cours" value="{{ old('volume_horaire_TP', '') }}" required>
                    <span class="help-block">{{ trans('cruds.schoolClass.fields.name_helper') }}</span>
                </div>

                <div class="form-group">
                    <label class="required" for="occ_per_week_Cours">Occurence par semaine ( Cours )</label>
                    <input class="form-control {{ $errors->has('occ_per_week_Cours') ? 'is-invalid' : '' }}" type="number" name="occ_per_week_Cours"
                        id="occ_per_week" value="{{ old('occ_per_week_Cours', '') }}" required>
                    <span class="help-block">{{ trans('cruds.schoolClass.fields.name_helper') }}</span>
                </div>

                <div class="form-group">
                    <label class="required" for="occ_per_week_TD">Occurence par semaine ( TD )</label>
                    <input class="form-control {{ $errors->has('occ_per_week_TD') ? 'is-invalid' : '' }}" type="number" name="occ_per_week_TD"
                        id="occ_per_week" value="{{ old('occ_per_week_TD', '') }}" required>
                    <span class="help-block">{{ trans('cruds.schoolClass.fields.name_helper') }}</span>
                </div>

                <div class="form-group">
                    <label class="required" for="occ_per_week_TP">Occurence par semaine ( TP )</label>
                    <input class="form-control {{ $errors->has('occ_per_week_TP') ? 'is-invalid' : '' }}" type="number" name="occ_per_week_TP"
                        id="occ_per_week" value="{{ old('occ_per_week_TP', '') }}" required>
                    <span class="help-block">{{ trans('cruds.schoolClass.fields.name_helper') }}</span>
                </div>

                <div class="form-group">
                    <label class="required" for="code_module">Module</label>

                    <select class="form-control select2 {{ $errors->has('module') ? 'is-invalid' : '' }}" name="code_module" id="code_module" required>
                        @foreach ($modules as $module)
                            <option value="{{ $module->id }}">{{ $module->intitule }}</option>
                        @endforeach
                    </select>

                    
                    @if ($errors->has('code_module'))
                        <div class="invalid-feedback">
                            {{ $errors->first('code_module') }}
                        </div>
                    @endif
                </div>

                <div class="form-group">
                    <button class="btn btn-danger" type="submit">
                        {{ trans('global.save') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
