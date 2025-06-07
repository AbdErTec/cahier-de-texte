@extends('layouts.app')

@section('content')
<!-- message here -->
<div class="container py-4">
    <div class="row">
        <h2>Mes Cahiers</h2>
    </div>
    <!-- <div class="row-4 mb-4 d-flex justify-content-between align-items-baseline">
        <div class=""> -->
    <!-- Left Arrow to go back one week -->
    <!-- <a href="" class="btn btn-link">
                <i class="bi bi-arrow-left-circle" style="font-size: 1.5rem; color: #28a745;"></i>
            </a>
        </div>
        <div class=""> -->
    <!-- Display current week (This will be dynamically set in controller) -->
    <!-- <h6>Week1</h6>
        </div>
        <div class=""> -->
    <!-- Right Arrow to go forward one week -->
    <!-- <a href="" class="btn btn-link">
                <i class="bi bi-arrow-right-circle" style="font-size: 1.5rem; color: #28a745;"></i>
            </a>
        </div>
    </div> -->

    <div class="row-4 pb-4">
        <a href="{{url('/cahierTexte/create')}}" class="btn btn-primary btn" role="button" aria-pressed="true">Ajouter un cahier</a>
    </div>

    <div class="row">
        @if($cahierTextes->isEmpty())
        <div class="row text-center">
            <strong>Aucun cahier de texte</strong>
        </div>
        @else
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">Filière</th>
                    <th scope="col">Groupe</th>
                    <th scope="col">Module</th>
                    <th scope="col">Date</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cahierTextes as $cahierTexte)
                <tr>
                    <th scope="row">{{ $cahierTexte->filiere_name }}</th>
                    <td>{{ $cahierTexte->groupe_name }}</td>
                    <td>{{ $cahierTexte->module_name }}</td>
                    <td>{{ $cahierTexte->date }}</td>
                    <td class="d-flex">
                        <a href="{{route('cahierTexte.edit', $cahierTexte->id)}}" class="btn btn-success mx-4" role="button">Modifier</a>
                        <a href="{{route('cahierTexte.downloadPDF', $cahierTexte->id)}}" class="btn btn-primary me-4" role="button">Telecharger</a>

                        <form method="POST" action="{{ route('cahierTexte.destroy', $cahierTexte->id) }}">
                            @csrf
                            @method('DELETE') <!-- This tells Laravel to treat the form as a DELETE request -->
                            <button type="submit" class="btn btn-danger">Supprimer</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
</div>
@endsection