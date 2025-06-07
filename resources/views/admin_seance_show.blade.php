@extends('layouts.admin')
@section('content')

<div class="container py-4 ">
    <div class="row d-flex">
        <div class="d-flex justify-content-between align-items-baseline mb-3">
            <h2 class="pb-2">Emploi du Temps</h2>
            <a href="{{ route('seance.index', $user_id) }}" class="btn btn-primary">Modifier</a>
            </div>
    </div>

    <div class="row">
        @if($seances->isEmpty())
        <div class="row text-center">
            <strong>Emploi du temps vide</strong>
        </div>
        @else
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr class="table-success">
                        <th scope="col">Jour</th>
                        <th scope="col">
                            <div class="d-flex justify-content-between">
                                <p>08:30</p>
                                <p>10:00</p>
                            </div>
                        </th>
                        <th scope="col">
                            <div class="d-flex justify-content-between">
                                <p>10:15</p>
                                <p>11:45</p>
                            </div>
                        </th>
                        <th scope="col">
                            <div class="d-flex justify-content-between">
                                <p>12:00</p>
                                <p>13:30</p>
                            </div>
                        </th>
                        <th scope="col">
                            <div class="d-flex justify-content-between">
                                <p>13:45</p>
                                <p>15:15</p>
                            </div>
                        </th>
                        <th scope="col">
                            <div class="d-flex justify-content-between">
                                <p>15:30</p>
                                <p>17:00</p>
                            </div>
                        </th>
                        <th scope="col">
                            <div class="d-flex justify-content-between">
                                <p>17:15</p>
                                <p>18:45</p>
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach (['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'] as $day)
                    <tr>
                        <!-- Display the day name -->
                        <td class="align-middle text-center font-weight-bold">{{ ucfirst($day) }}</td>

                        @foreach (['08:30-10:00', '10:15-11:45', '12:00-13:30', '13:45-15:15', '15:30-17:00', '17:15-18:45'] as $index => $timeslot)
                        @php
                        [$start, $end] = explode('-', $timeslot);
                        $session = null;
                        $spanCount = 1;

                        
                        foreach ($seances as $seance) {
                            if ($seance->jour === $day &&
                            \Carbon\Carbon::parse($seance->h_debut)->format('H:i') === $start) {
                                // Check if the session ends after the current time slot
                                if (\Carbon\Carbon::parse($seance->h_fin)->format('H:i') > $start) {
                                    $session = $seance;

                                    
                                    if (\Carbon\Carbon::parse($seance->h_fin)->format('H:i') > $end) {
                                        $spanCount = 2;
                                    }
                                    break;
                                }
                            }
                        }
                        @endphp

                        <!-- Display the session in merged cells -->
                        <td @if ($session) colspan="{{ $spanCount }}" @endif>
                            @if ($session)
                            <p class="text-center">
                                <strong>{{ $session->module_name }}</strong> <br>
                                {{ $session->filiere_name . '-' . $session->groupe_name }}
                            </p>
                            @else
                            <!-- Empty timeslot -->
                            <p class="text-muted text-center">-</p>
                            @endif
                        </td>

                        @endforeach
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>
</div>
@endsection
