@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        Modifier un groupe
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.groups.update", [$group->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="intitule">Intitule</label>
                <input class="form-control {{ $errors->has('intitule') ? 'is-invalid' : '' }}" type="text" name="intitule" id="intitule" value="{{ old('intitule', $group->name) }}" required>
                @if($errors->has('intitule'))
                    <div class="invalid-feedback">
                        {{ $errors->first('intitule') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.schoolClass.fields.name_helper') }}</span>
            </div>
            
            <div class="form-group">
                <label class="required" for="section_id">Section</label>

                <select class="form-control select2 {{ $errors->has('section') ? 'is-invalid' : '' }}" name="section_id" id="section_id" required>
                    @foreach ($sections as $section)
                        <option value="{{ $section->id }}">{{ $section->Intitule }}</option>
                    @endforeach
                </select>

                @if ($errors->has('section_id'))
                    <div class="invalid-feedback">
                        {{ $errors->first('section_id') }}
                    </div>
                @endif
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