@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        Ajouter une seance
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.lessons.store") }}" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label class="required" for="section_id">Section</label>
                <input type="text" class="form-control" name="section_id" id="section_id" required readonly value="{{$section->Intitule}}">
                @if($errors->has('section'))
                    <div class="invalid-feedback">
                        {{ $errors->first('section') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.lesson.fields.class_helper') }}</span>
            </div>

            <div class="form-group">
                <input hidden type="text" class="form-control" name="timetable_id" id="timetable_id" required readonly value="{{$timetableId}}">
                @if($errors->has('timetable'))
                    <div class="invalid-feedback">
                        {{ $errors->first('timetable') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.lesson.fields.class_helper') }}</span>
            </div>

            {{-- <div class="form-group">
                <label class="required" for="group_id">Groupe</label>
                <select class="form-control select2 {{ $errors->has('group') ? 'is-invalid' : '' }}" name="group_id" id="group_id" required>
                    @foreach($groups as $id => $group)
                        <option value="{{ $id }}" {{ old('group_id') == $id ? 'selected' : '' }}>{{ $group->intitule }}</option>
                    @endforeach
                </select>
                @if($errors->has('group'))
                    <div class="invalid-feedback">
                        {{ $errors->first('group') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.lesson.fields.class_helper') }}</span>
            </div> --}}

            <div class="form-group">
                <label class="required" for="salle_id">Salle</label>
                <select class="form-control select2 {{ $errors->has('salle') ? 'is-invalid' : '' }}" name="salle_id" id="salle_id" required>
                    @foreach($salles as $id => $salle)
                        <option value="{{ $salle->id }}" {{ old('salle_id') == $id ? 'selected' : '' }}>{{ $salle->label }}</option>
                    @endforeach
                </select>
                @if($errors->has('salle'))
                    <div class="invalid-feedback">
                        {{ $errors->first('salle') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.lesson.fields.class_helper') }}</span>
            </div>

            <div class="form-group">
                <label class="required" for="type">Type</label>
                <input class="form-control" type="text" name="type" id="type" required readonly value="{{$type}}">
                @if($errors->has('type'))
                    <div class="invalid-feedback">
                        {{ $errors->first('type') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.lesson.fields.class_helper') }}</span>
            </div>

            <div class="form-group">
                <label class="required" for="code_matiere">Element</label>
                <select class="form-control select2 {{ $errors->has('element') ? 'is-invalid' : '' }}" name="code_matiere" id="code_matiere" required>
                    @foreach($schoolClasses as $id => $schoolClass)
                        <option value="{{ $schoolClass->id }}" {{ old('code_matiere') == $id ? 'selected' : '' }}>{{ $schoolClass->name }}</option>
                    @endforeach
                </select>
                @if($errors->has('schoolClass'))
                    <div class="invalid-feedback">
                        {{ $errors->first('schoolClass') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.lesson.fields.class_helper') }}</span>
            </div>

            <div class="form-group">
                <label class="required" for="teacher_id">Professeur</label>
                <input class="form-control {{ $errors->has('teacher') ? 'is-invalid' : '' }}" type="text" name="teacher_name" id="teacher_name" value="{{ $teacher->name }}" readonly required>
                <input type="hidden" name="teacher_id" id="teacher_id" value="{{ $teacher->id }}">
                                @if($errors->has('weekday'))
                    <div class="invalid-feedback">
                        {{ $errors->first('weekday') }}
                    </div>
                @endif
                @if($errors->has('teacher'))
                    <div class="invalid-feedback">
                        {{ $errors->first('teacher') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.lesson.fields.teacher_helper') }}</span>
            </div>
            <div class="form-group">
                @php
                $weekdays = [
                    1 => 'Lundi',
                    2 => 'Mardi',
                    3 => 'Mercredi',
                    4 => 'Jeudi',
                    5 => 'Vendredi',
                    6 => 'Samedi',
                ]   
                @endphp
                <label class="required" for="weekday">Jour</label>
                <select class="form-control {{ $errors->has('weekday') ? 'is-invalid' : '' }}" name="weekday" id="weekday" required>
                    @foreach($weekdays as $key => $day)
                        <option value="{{ $key }}" @if(old('weekday') == $key) selected @endif>{{ $day }}</option>
                    @endforeach
                </select>
                                @if($errors->has('weekday'))
                    <div class="invalid-feedback">
                        {{ $errors->first('weekday') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.lesson.fields.weekday_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="start_time">Heure de debut</label>
                <input class="form-control  {{ $errors->has('start_time') ? 'is-invalid' : '' }}" type="text" name="start_time" id="start_time" value="{{ old('start_time') }}" required>
                @if($errors->has('start_time'))
                    <div class="invalid-feedback">
                        {{ $errors->first('start_time') }}
                    </div>
                @endif
            </div>
            <div class="form-group">
                <label class="required" for="end_time">Heure de fin</label>
                <input class="form-control {{ $errors->has('end_time') ? 'is-invalid' : '' }}" type="text" name="end_time" id="end_time" value="{{ old('end_time') }}" required>
                @if($errors->has('end_time'))
                    <div class="invalid-feedback">
                        {{ $errors->first('end_time') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.lesson.fields.end_time_helper') }}</span>
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