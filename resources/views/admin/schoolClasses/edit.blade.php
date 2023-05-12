@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.schoolClass.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.school-classes.update", [$schoolClass->id]) }}" enctype="multipart/form-data">
            @method('PUT')
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
                    <label class="required" for="volume_horaire">Volume Horaire</label>
                    <input class="form-control {{ $errors->has('volume_horaire') ? 'is-invalid' : '' }}" type="number" name="volume_horaire"
                        id="volume_horaire" value="{{ old('volume_horaire', '') }}" required>
                    <span class="help-block">{{ trans('cruds.schoolClass.fields.name_helper') }}</span>
                </div>

                <div class="form-group">
                    <label class="required" for="occ_per_week">Occurence par semaine</label>
                    <input class="form-control {{ $errors->has('occ_per_week') ? 'is-invalid' : '' }}" type="number" name="occ_per_week"
                        id="occ_per_week" value="{{ old('occ_per_week', '') }}" required>
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