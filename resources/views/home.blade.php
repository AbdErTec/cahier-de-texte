@extends('layouts.app')

@section('content')

<div class="container">

    <div class="row mb-4">
        <div class="row justify-content-center">
            <div class="col">
                <form class="d-flex" method="GET" action="{{ route('search.user') }}">
                    <div class="input-group">
                        <input class="form-control form-control" type="search" name="item_a_rechercher" placeholder="Rechercher un cahier de texte..." aria-label="Search">
                        <button class="btn btn-primary px-4" type="submit">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="row">
        <h2 class="pb-2">Emploi du Temps</h2>
    </div>

    <div class="row">
        @if ($seances->isEmpty())
        <div class="row text-center pb-4">
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

                        <td @if ($session) colspan="{{ $spanCount }}" @endif>
                            @if ($session)
                            <p class="text-center">
                                <strong>{{ $session->module_name }}</strong> <br>
                                {{ $session->filiere_name . '-' . $session->groupe_name }}
                            </p>
                            @else
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

    <div class="row">
        <div class="d-flex justify-content-between">
            <!-- Prochaine Séance -->
            <div class="col-md-6 me-3">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        Prochaine Séance
                    </div>
                    <div class="card-body">
                        @if ($seanceProchaine)
                        <h5 class="card-title"></h5>
                        <p class="card-text">
                            <strong>Module :</strong> {{$seanceProchaine->module_name}} <br>
                            <strong>Groupe :</strong> {{$seanceProchaine->filiere_name . '-' . $seanceProchaine->groupe_name}}<br>
                            <strong> Horaire :</strong> {{\Carbon\Carbon::parse($seanceProchaine->h_debut)->format('H:i') . '-' . \Carbon\Carbon::parse($seanceProchaine->h_fin)->format('H:i')}}<br>
                        </p>
                        @else
                        <p class="card-body">
                            <strong>Acune Séance à venir</strong>
                        </p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Liste des dernières séances -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        Séances enseignées aujourd'hui
                    </div>
                    <div class="card-body">
                        @if($seancesEnseignes->isEmpty())
                        <p class="card-body">
                            <strong>Aucune Séance enseignée aujourd'hui</strong>
                        </p>
                        @else
                        <ul class="list-group">
                            @foreach($seancesEnseignes as $sE)
                            <li class="list-group-item">
                                <strong>Module :</strong> {{$sE->module_name}} <br>
                                <strong>Groupe :</strong> {{$sE->filiere_name . '-' . $sE->groupe_name}}<br>
                                <strong>Horaire :</strong> {{\Carbon\Carbon::parse($sE->h_debut)->format('H:i') . '-' . \Carbon\Carbon::parse($sE->h_fin)->format('H:i')}}<br>
                                <a href="#" class="btn btn-primary btn-sm mt-2">Ajouter Cahier de Texte</a>
                            </li>
                            @endforeach
                        </ul>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
