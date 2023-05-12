@extends('layouts.admin')
@section('content')
    @can('lesson_create')
        <div style="margin-bottom: 10px;" class="row center text-center">

            <div class="col-lg-12">
                <a class="btn btn-success btn-optimize" href="{{ route('admin.timetableoptimizer.create', ['seconds' => 20]) }}" data-toggle="modal" data-target=".wait-modal">
                    Optimiser pour 20 secondes
                </a>
                <a class="btn btn-success btn-optimize" href="{{ route('admin.timetableoptimizer.create', ['seconds' => 60]) }}" data-toggle="modal" data-target=".wait-modal">
                    Optimiser pour une minute
                </a>
                <a class="btn btn-success btn-optimize" href="{{ route('admin.timetableoptimizer.create', ['seconds' => 600]) }}" data-toggle="modal" data-target=".wait-modal">
                    Optimiser pour 10 minutes
                </a>
                <a class="btn btn-success btn-optimize" href="{{ route('admin.timetableoptimizer.create', ['seconds' => 1800]) }}" data-toggle="modal" data-target=".wait-modal">
                    Optimiser pour 30 minutes
                </a>
            </div>
        </div>

        <div style="margin-bottom: 10px;" class="card p-4">
            
            @if(isset($score))
                @php
                $last_part = substr($score, -13);   
                @endphp
                Votre optimisation est terminée. Vos emplois ont violé {{$last_part ?? "Vous n'avez pas encore optimise vos emplos du temps"}} contraintes
            
            @else <b>Vous n'avez pas encore optimisé vos emplois du temps</b>
            @endif

        </div>



        <div class="modal wait-modal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <p>Veuillez patienter. Vos emplois du temps sont en cours d'optimisation ......</p>
                    </div>
                </div>
            </div>
        </div>

    @endcan
@endsection

@section('scripts')
    @parent
    <script>
        $(document).ready(function() {
            $('.btn-optimize').click(function(e) {
                e.preventDefault(); // prevent the default behavior of clicking the link

                $('modal').modal('show'); // show the modal

                
                var href = $(this).attr('href'); // get the href link of the clicked button
                setTimeout(function() {
                    window.location.href = href; // go to the href link after a set time
                }, 2000); // set the time delay in milliseconds (here 2000 milliseconds or 2 seconds)
            });
        });
    </script>
@endsection
