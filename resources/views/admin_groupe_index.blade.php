@extends('layouts.admin')
@section('content')
@include('layouts.message')
<div class="container py-4">
    <div class="row">
        <h2>Gestionnaire de groupes</h2>
    </div>


    <div class="row mt-5">
        @if($groupes->isEmpty())
        <div class="row text-center">
            <strong>Aucun groupe</strong>
        </div>
        @else
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">Groupe</th>
                    <th scope="col">Filiere</th>
                    <th scope="col">Nombre des etudiants</th>
                    <!-- <th scope="col">Nombre de profs</th> -->
                    <!-- <th scope="col">Actions</th> -->
                    <!-- <th scope="col">Date</th> -->
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($groupes as $groupe)
                <tr>
                    <td>{{ $groupe->nom_groupe }}</th> <!-- Fixed 'firsname' typo -->
                    <td>{{ $groupe->filiere_name }}</td> <!-- Fixed 'lasname' typo -->
                    <td>nbr des etudiants</td>
                    <!-- <td></td> -->
                    <td class="d-flex ">
                        <!-- <a href="/" class="btn btn-success mx-4" role="button">Modifier</a> -->
                        <!-- Filière modal button -->
                        <a href="#" data-bs-toggle="modal" data-bs-target="#groupeModal{{ $groupe->id }}" class="btn mx-4 btn-success ">Modifier</a>

                        <div class="modal fade" id="groupeModal{{ $groupe->id }}" tabindex="-1" aria-labelledby="groupeModal" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Modifier un groupe</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="{{route('groupe.update', $groupe->id)}}">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-body">

                                            <!-- Groupe body -->
                                            <!-- Nom Groupe -->
                                            <div class="mb-3">
                                                <label for="titre" class="form-label">Groupe</label>
                                                <input type="text" id="titre" name="groupe" class="form-control @error('groupe') is-invalid @enderror" value="{{$groupe->nom_groupe}}" placeholder="Ex: Groupe 3" required autofocus>
                                            </div>
                                            <!-- nom filière -->
                                            <div class="mb-3">
                                                <label for="titre" class="form-label">Filière</label>
                                                <input type="text" id="titre" name="nom_filiere" class="form-control @error('nom_filiere') is-invalid @enderror" value="{{$groupe->filiere_name}}" placeholder="Ex: 3IIR" required autofocus>
                                                @error('nom_filiere')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>Filière Introuvable</strong>
                                                </span>
                                                @enderror
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



                        <form method="POST" action="{{route('groupe.destroy', $groupe->id)}}">
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