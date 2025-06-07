@extends('layouts.admin')
@section('content')
@include('layouts.message')
<div class="container py-4">
    <div class="row">
        <h2>Gestionnaire des modules</h2>
    </div>
    <div class="row mt-5">
        @if($modules->isEmpty())
        <div class="row text-center">
            <strong>Aucun module</strong>
        </div>
        @else
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Nom</th>
                    <th scope="col">Filieres</th>
                    <th scope="col">Profs</th>
                    <!-- <th scope="col">Actions</th> -->
                    <!-- <th scope="col">Date</th> -->
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($modules as $module)
                <tr>
                    <td>{{ $module->id }}</th> <!-- Fixed 'firsname' typo -->
                    <td>{{ $module->nom_module }}</td> <!-- Fixed 'lasname' typo -->
                    <td>{{ $module->filiere_name}}</td>
                    <td>Profs li kay 9eriw l module</td>
                    <td class="d-flex ">

                        <!-- <a href="/" class="btn btn-success mx-4" role="button">Modifier</a> -->
                        <!-- Filière modal button -->
                        <a href="#" data-bs-toggle="modal" data-bs-target="#moduleModal{{ $module->id }}" class="btn mx-4 btn-success ">Modifier</a>

                        <!-- Filière Modal for each filière -->
                        <div class="modal fade" id="moduleModal{{ $module->id }}" tabindex="-1" aria-labelledby="moduleModal{{ $module->id }}Label" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="moduleModal{{ $module->id }}Label">Modifier le module</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="{{route('module.update', $module->id)}}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="nom_module" class="form-label">Nom du module</label>
                                                <input type="text" name="nom_module" class="form-control @error('nom_module') is-invalid @enderror" value="{{ $module->nom_module }}" placeholder="Ex: Outils de developement 1" required autofocus>
                                            </div>
                                            <div class="mb-3">
                                                <label for="nom_filiere" class="form-label">Nom de la filière</label>
                                                <input type="text" name="nom_filiere" class="form-control @error('nom_filiere') is-invalid @enderror" value="{{ $module->nom_filiere }}" placeholder="Ex: 3IIR" required autofocus>
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



                        <form method="POST" action="{{route('module.destroy', $module->id)}}">
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