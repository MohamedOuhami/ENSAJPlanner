@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        Modifier une section
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.sections.update", [$section->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="intitule">Intitule</label>
                <input class="form-control {{ $errors->has('intitule') ? 'is-invalid' : '' }}" type="text" name="intitule" id="intitule" value="{{ old('intitule', $section->name) }}" required>
                @if($errors->has('intitule'))
                    <div class="invalid-feedback">
                        {{ $errors->first('intitule') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.schoolClass.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    Sauvegarder
                </button>
            </div>
        </form>
    </div>
</div>



@endsection