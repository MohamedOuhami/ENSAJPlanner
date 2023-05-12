@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        Ajouter une salle
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.salles.store") }}" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label class="required" for="label">Libelle</label>
                <input class="form-control {{ $errors->has('label') ? 'is-invalid' : '' }}" type="text" name="label" id="label" value="{{ old('label', '') }}" required>
                @if($errors->has('label'))
                    <div class="invalid-feedback">
                        {{ $errors->first('label') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.schoolClass.fields.name_helper') }}</span>
            </div>

            <div class="form-group">
                <label class="required" for="type">Type</label>
                <select class='form-control' name="type" id="type">
                    <option value="Cours">Cours</option>
                    <option value="TD">TD</option>
                    <option value="TP">TP</option>
                </select>
                @if($errors->has('type'))
                    <div class="invalid-feedback">
                        {{ $errors->first('type') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.schoolClass.fields.name_helper') }}</span>
            </div>

            <div class="form-group">
                <label class="required" for="capacity">Capacite</label>
                <input class="form-control {{ $errors->has('capacity') ? 'is-invalid' : '' }}" type="number" name="capacity" id="capacity" value="{{ old('capacity', '') }}" required>
                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('capacity') }}
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