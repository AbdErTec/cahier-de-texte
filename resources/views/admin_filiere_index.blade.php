@extends('layouts.admin')
@section('content')
@include('layouts.message')
<div class="container py-4">
    <div class="row">
        <h2>Gestionnaire de filières</h2>
    </div>


    <div class="row mt-5">
        @if($filieres->isEmpty())
        <div class="row text-center">
            <strong>Aucune filière</strong>
        </div>
        @else
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Nom</th>
                    <th scope="col">Nombre de modules</th>
                    <th scope="col">Nombre de profs</th>
                    <!-- <th scope="col">Actions</th> -->
                    <!-- <th scope="col">Date</th> -->
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($filieres as $filiere)
                <tr>
                    <td>{{ $filiere->id }}</th> <!-- Fixed 'firsname' typo -->
                    <td>{{ $filiere->nom_filiere }}</td> <!-- Fixed 'lasname' typo -->
                    <td>{{--$modulesCount--}} ba9i</td>
                    <td>7ta ndir attach()</td>
                    <td class="d-flex ">

                        <!-- <a href="/" class="btn btn-success mx-4" role="button">Modifier</a> -->
                        <!-- Filière modal button -->
                        <a href="#" data-bs-toggle="modal" data-bs-target="#filiereModal{{ $filiere->id }}" class="btn mx-4 btn-success ">Modifier</a>

                        <!-- Filière Modal for each filière -->
                        <div class="modal fade" id="filiereModal{{ $filiere->id }}" tabindex="-1" aria-labelledby="filiereModal{{ $filiere->id }}Label" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="filiereModal{{ $filiere->id }}Label">Modifier la filière</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route('filiere.update', $filiere->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="nom_filiere" class="form-label">Nom de la filière</label>
                                                <input type="text" name="nom_filiere" class="form-control @error('nom_filiere') is-invalid @enderror" value="{{ $filiere->nom_filiere }}" placeholder="Ex: 3IIR" required autofocus>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                            <button type="submit" class="btn btn-primary">Enregistrer</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>



                        <form method="POST" action="{{route('filiere.destroy', $filiere->id)}}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Supprimer</button>
                        </form>
                        <!-- <a href="" class="btn btn-primary mx-4" role="button">Plus d'infos</a> -->

                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
</div>
@endsection