@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        Ajouter une section
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.sections.store") }}" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label class="required" for="intitule">Intitule</label>
                <input class="form-control {{ $errors->has('intitule') ? 'is-invalid' : '' }}" type="text" name="intitule" id="intitule" value="{{ old('intitule', '') }}" required>
                @if($errors->has('intitule'))
                    <div class="invalid-feedback">
                        {{ $errors->first('intitule') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.schoolClass.fields.name_helper') }}</span>
            </div>

            <div class="form-group">
                <label class="required" for="Semestre">Semester</label>
                <select class='form-control' name="Semester" id="Semester">
                    <option value="S1">S1</option>
                    <option value="S2">S2</option>
                    <option value="S3">S3</option>
                    <option value="S4">S4</option>
                </select>
                @if($errors->has('Semester'))
                    <div class="invalid-feedback">
                        {{ $errors->first('Semester') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.schoolClass.fields.name_helper') }}</span>
            </div>

            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    Ajouter
                </button>
            </div>
        </form>
    </div>
</div>



@endsection