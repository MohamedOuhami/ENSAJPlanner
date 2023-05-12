@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        Ajouter un emploi du temps
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.timetables.store") }}" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label class="required" for="admin_id">Admin</label>

                <select class="form-control select2 {{ $errors->has('admin_id') ? 'is-invalid' : '' }}" name="admin_id" id="admin_id" required readonly>
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                </select>

                @if($errors->has('admin_id'))
                    <div class="invalid-feedback">
                        {{ $errors->first('admin_id') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.schoolClass.fields.name_helper') }}</span>
            </div>

            <div class="form-group">
                <label for="nbr_weeks" class="required">Nombre de semaines</label>

                <input type="Number" name="nbr_weeks" id ="nbr_weeks" class="form-control">
            </div>

            <div class="form-group">
                <label class="required" for="section_id">Section</label>

                <select class="form-control select2 {{ $errors->has('section') ? 'is-invalid' : '' }}" name="section_id" id="section_id" required>
                    @foreach ($sections as $section)
                        <option value="{{ $section->id }}">{{ $section->Intitule ." - " . $section->Semester}}</option>
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
                    Ajouter
                </button>
            </div>
        </form>
    </div>
</div>



@endsection