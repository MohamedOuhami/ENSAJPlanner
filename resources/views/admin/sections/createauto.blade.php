@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        Creation automatique des sections
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.sections.storeauto") }}" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="nbr_max">Nombre Maximale des etudiants</label>
                <input class="form-control" type="number" name="nbr_max" id="nbr_max">
            </div>

            <div class="form-group">
                <label for="semester">Semester</label>

                <select class="form-control" name="semester" id="semester">
                    <option value="S1">S1</option>
                    <option value="S2">S2</option>
                    <option value="S3">S3</option>
                    <option value="S4">S4</option>
                </select>
            </div>

            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    Auto
                </button>
            </div>
        </form>
    </div>
</div>



@endsection