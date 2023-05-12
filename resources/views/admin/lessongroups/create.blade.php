@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            Ajouter les professeurs a un emploi
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('admin.lessongroup.store',$lesson_id) }}" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label class="required" for="teacher_id">Group</label>
                    <select class="form-control select2 {{ $errors->has('group_id') ? 'is-invalid' : '' }}"
                        name="group_id" id="group_id" required multiple>
                        @foreach ($group_ids as $group_id)
                            @php
                                $group = App\Group::find($group_id);
                            @endphp
                            <option value="{{ $group->id }}">{{ $group->intitule }}</option>
                        @endforeach
                    </select>

                    @if ($errors->has('group_id'))
                        <div class="invalid-feedback">
                            {{ $errors->first('group_id') }}
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
