@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        Modifier un module
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.modules.update", [$module->id]) }}" enctype="multipart/form-data">
            @method('PUT')
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
                <label class="required" for="volume_horaire">Volume Horaire</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="number" name="volume_horaire" id="volume_horaire" value="{{ old('volume_horaire', '') }}" required>
                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.schoolClass.fields.name_helper') }}</span>
            </div>

            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    Modifier
                </button>
            </div>
        </form>
    </div>
</div>



@endsection