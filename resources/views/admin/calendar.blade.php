@extends('layouts.admin')
@section('content')
    <div class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        Emploi du temps
                    </div>

                    <div class="card-body">


                        <table class="table table-bordered">
                            <thead class="center">
                                <th width="125">Time</th>
                                @foreach ($weekDays as $day)
                                    <th>{{ $day }}</th>
                                @endforeach
                            </thead>
                            <tbody>
                                @foreach ($calendarData as $time => $days)
                                    <tr>
                                        <td>{{ $time }}</td>
                                        @foreach ($days as $dayIndex => $lesson)
                                            @if (isset($lesson))
                                                <td rowspan="1" style="background-color:#f0f0f0">

                                                    @foreach ($lesson as $lesson_item)
                                                        {{ $lesson_item['class_name'] }}<br>
                                                        {{ $lesson_item['type'] }}<br>
                                                        Section : {{ $lesson_item['section']}}<br>
                                                        @if ($lesson_item['type'] == 'Cours')
                                                            Amphi : {{ $lesson_item['salle'] }}<br>
                                                            {{ $lesson_item['weekTextCours'] }}<br>
                                                        @elseif($lesson_item['type'] == 'TD')
                                                            Salle : {{ $lesson_item['salle'] }}<br>
                                                            Groupe : {{ $lesson_item['groups'][0] }}<br>
                                                            {{ $lesson_item['weekTextTD'] }}<br>
                                                        @endif
                                                        Professor : {{ $lesson_item['professor'] }}<br>

                                                        ================
                                                    @endforeach
                                                </td>
                                            @else
                                                <td rowspan="1"></td>
                                            @endif
                                            {{-- @php dump($days[$dayIndex])@endphp --}}
                                        @endforeach
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
