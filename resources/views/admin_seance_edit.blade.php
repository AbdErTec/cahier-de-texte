@extends('layouts.admin')
@section('content')
@include('layouts.message')
<div class="container pb-4">
    <div class="row">
        <div class="d-flex justify-content-between align-items-baseline">
            <h2>Gestionnaire des seances</h2>
            <a href="#" data-bs-toggle="modal" data-bs-target="#seanceModal" class="btn mx-4 btn-primary px-3 ">Ajouter</a>
        </div>
    </div>
    <!-- ajouter sseance modal  -->
    <!-- <p>user ID: {{$user_id}}</p> -->

    <div class="modal fade" id="seanceModal" tabindex="-1" aria-labelledby="seanceModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ajouter une séance</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
               
                <form action="{{ route('seance.store', $user_id) }}" method="POST">
                    @csrf
                    <div class="modal-body">

                        <!-- Groupe body -->
                        <div class="mb-3">
                            <label for="titre" class="form-label">Module</label>
                            <input type="text" id="titre" name="nom_module" class="form-control @error('nom_module') is-invalid @enderror" placeholder="Ex: Outils de develepement 1" required autofocus>
                            @error('module')
                            <span class="invalid-feedback" role="alert">
                                <strong>Module Introuvable</strong>
                            </span>
                            @enderror
                        </div>
                        <!-- Nom Groupe -->
                        <div class="mb-3">
                            <label for="titre" class="form-label">Groupe</label>
                            <input type="text" id="titre" name="nom_groupe" class="form-control @error('nom_groupe') is-invalid @enderror" placeholder="Ex: Groupe 3" required autofocus>
                            @error('groupe')
                            <span class="invalid-feedback" role="alert">
                                <strong>Groupe Introuvable</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="titre" class="form-label">Jour</label>
                            <input type="text" id="titre" name="jour" class="form-control @error('jour') is-invalid @enderror" placeholder="" required autofocus>
                            @error('jour')
                            <span class="invalid-feedback" role="alert">
                                <strong>jour invalide</strong>
                            </span>
                            @enderror
                        </div>
                        <!-- nom filière -->
                        <div class="d-flex justify-content-between">
                            <div class="col-4 mb-3">
                                <label for="titre" class="form-label">Début</label>
                                <input type="time" id="titre" name="h_debut" class="form-control @error('h_debut') is-invalid @enderror" required autofocus>
                                @error('h_debut')
                                <span class="invalid-feedback" role="alert">
                                    <strong>Entrée invalide Introuvable</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-4 mb-3" style="margin-right:35px;">
                                <label for="titre" class="form-label">Fin</label>
                                <input type="time" id="titre" name="h_fin" class="form-control @error('fh_in') is-invalid @enderror" required autofocus>
                                @error('h_fin')
                                <span class="invalid-feedback" role="alert">
                                    <strong>Entrée invalide Introuvable</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                        <button type="submit" class="btn btn-primary">Ajouter</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <div class="row">

    </div>

    <div class="row mt-5">
        @if($seances->isEmpty())
        <div class="row text-center">
            <strong>Aucune séance</strong>
        </div>
        @else
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">Module</th>
                    <th scope="col">Groupe</th>
                    <th scope="col">Jour</th>
                    <th scope="col">Début</th>
                    <th scope="col">Fin</th>
                    <!-- <th scope="col">Nombre de profs</th> -->
                    <!-- <th scope="col">Actions</th> -->
                    <!-- <th scope="col">Date</th> -->
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($seances as $seance)
                <tr>
                    <td>{{ $seance->module_name }}</th> <!-- Fixed 'firsname' typo -->
                    <td>{{ $seance->filiere_name }}</td> <!-- Fixed 'lasname' typo -->
                    <td>{{ $seance->jour }}</td> <!-- Fixed 'lasname' typo -->
                    <td>{{\Carbon\Carbon::parse($seance->h_debut)->format('H:i')}}</td>
                    <td>{{\Carbon\Carbon::parse($seance->h_fin)->format('H:i')}}</td>
                    <td class="d-flex ">
                        <!-- <a href="/" class="btn btn-success mx-4" role="button">Modifier</a> -->
                        <!-- Filière modal button -->
                        <a href="#" data-bs-toggle="modal" data-bs-target="#seanceModal{{ $seance->id }}" class="btn mx-4 btn-success ">Modifier</a>

                        <div class="modal fade" id="seanceModal{{ $seance->id }}" tabindex="-1" aria-labelledby="seanceModal" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Modifier une séance</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="{{route('seance.update', $seance->id)}}" method="POST">
                                        @method('PUT')
                                        @csrf
                                        <div class="modal-body">

                                            <!-- Groupe body -->
                                            <div class="mb-3">
                                                <label for="titre" class="form-label">Module</label>
                                                <input type="text" value="{{$seance->module_name}}" id="titre" name="nom_module" class="form-control @error('nom_module') is-invalid @enderror" placeholder="Ex: Outils de develepement 1" required autofocus>
                                                @error('module')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>Module Introuvable</strong>
                                                </span>
                                                @enderror
                                            </div>
                                            <!-- Nom Groupe -->
                                            <div class="mb-3">
                                                <label for="titre" class="form-label">Groupe</label>
                                                <input type="text" value="{{$seance->groupe_name}}" id="titre" name="nom_groupe" class="form-control @error('nom_groupe') is-invalid @enderror" placeholder="Ex: Groupe 3" required autofocus>
                                                @error('groupe')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>Groupe Introuvable</strong>
                                                </span>
                                                @enderror
                                            </div>
                                            <div class="mb-3">
                                                <label for="titre" class="form-label">Jour</label>
                                                <input type="text" id="titre" value="{{$seance->jour}}" name="jour" class="form-control @error('jour') is-invalid @enderror" placeholder="" required autofocus>
                                                @error('jour')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>jour invalide</strong>
                                                </span>
                                                @enderror
                                            </div>
                                            <!-- nom filière -->
                                            <div class="d-flex justify-content-between">
                                                <div class="col-4 mb-3">
                                                    <label for="titre" class="form-label">Début</label>
                                                    <input type="time" id="titre" value="{{$seance->h_debut}}" name="h_debut" class="form-control @error('h_debut') is-invalid @enderror" required autofocus>
                                                    @error('h_debut')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>Entrée invalide</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                                <div class="col-4 mb-3" style="margin-right:35px;">
                                                    <label for="titre" class="form-label">Fin</label>
                                                    <input type="time" id="titre" value="{{$seance->h_fin}}" name="h_fin" class="form-control @error('fh_in') is-invalid @enderror" required autofocus>
                                                    @error('h_fin')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>Entrée invalide </strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                            </div>

                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                            <button type="submit" class="btn btn-primary">Ajouter</button>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>



                        <form method="POST" action="{{route('seance.destroy', $seance->id)}}">
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