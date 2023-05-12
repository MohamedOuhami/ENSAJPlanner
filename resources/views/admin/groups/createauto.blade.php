@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        Creation automatique des groupes
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.groups.storeauto") }}" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="nbr_max">Nombre Maximale des etudiants en groupe</label>
                <input class="form-control" type="number" name="nbr_max" id="nbr_max">
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