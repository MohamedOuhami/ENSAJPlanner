@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            Ajouter les professeurs a un emploi
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('admin.teachertimetables.store',$timetable_id) }}" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label class="required" for="teacher_id">Teacher</label>
                    <select class="form-control select2 {{ $errors->has('teacher_id') ? 'is-invalid' : '' }}"
                        name="teacher_id[]" id="teacher_id" required multiple>
                        @foreach ($teachers_ids as $teacher_id)
                            @php
                                $teacher = App\User::find($teacher_id);
                            @endphp
                            <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                        @endforeach
                    </select>

                    @if ($errors->has('teacher_id'))
                        <div class="invalid-feedback">
                            {{ $errors->first('teacher_id') }}
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
