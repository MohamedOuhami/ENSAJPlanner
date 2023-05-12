@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        Ajouter un module
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.modules.store") }}" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label class="required" for="name">Intitule</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="intitule" id="intitule" value="{{ old('intitule', '') }}" required>
                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.schoolClass.fields.name_helper') }}</span>
            </div>

            <div class="form-group">
                <label class="required" for="Semester">Semestre</label>
                <select class="form-control" name="Semester" id="Semester">
                    <option value="S1">S1</option>
                    <option value="S2">S2</option>
                    <option value="S3">S3</option>
                    <option value="S4">S4</option>
                </select>
                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
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