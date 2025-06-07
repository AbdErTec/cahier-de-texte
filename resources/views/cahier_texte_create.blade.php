@extends('layouts.app')
@section('content')
<div class="container py-4">
    <div class="row mb-4">
        <div class="col">
            <h1 class="text-center text-success">Nouveau Cahier de Texte</h1>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <form action="{{route('cahierTexte.store')}}" method="POST" class="bg-light p-4 rounded shadow-sm" enctype="multipart/form-data">
                <!-- CSRF Token (Add this if you're using Laravel for form submission) -->
                @csrf
                <!-- Group Dropdown -->
                <!-- <div class="mb-3">
                    <label for="groupe" class="form-label">Groupe</label>
                    <select id="groupe" name="groupe" class="form-select" required>
                        <option value="" selected>Selectionner un groupe</option>
                        <option value="Groupe 1">Groupe 1</option>
                        <option value="Groupe 2">Groupe 2</option> -->
                <!-- Add more options as needed -->
                <!-- </select>
                </div> -->

                <!-- Date de la Séance -->
                <div class="mb-3">
                    <label for="date_seance" class="form-label">Date de la séance</label>
                    <input type="date" id="date_seance" name="date_seance" class="form-control" required>
                </div>

                <!-- Nom Module -->
                <div class="mb-3">
                    <label for="titre" class="form-label">Module</label>
                    <input type="text" id="titre" name="module" class="form-control @error('module') is-invalid @enderror" placeholder="Ex: Outils de Developement 1" required autofocus>
                    @error('module')
                    <span class="invalid-feedback" role="alert">
                        <strong>Module Introuvable</strong>
                    </span>
                    @enderror
                </div>

                <!-- Titre du Cours -->
                <div class="mb-3">
                    <label for="titre" class="form-label">Titre du cours</label>
                    <input type="text" id="titre" name="titre" class="form-control" placeholder="Ex: Introduction à Laravel" required>
                </div>

                <!-- Objectifs du Cours -->
                <div class="mb-3">
                    <label for="objectifs" class="form-label">Objectifs du cours</label>
                    <textarea id="objectifs" name="objectifs" class="form-control" rows="2" placeholder="Objectifs à atteindre" required></textarea>
                </div>

                <!-- Contenu Abordé -->
                <div class="mb-3">
                    <label for="contenu" class="form-label">Contenu abordé</label>
                    <textarea id="contenu" name="contenu" class="form-control" rows="2 " placeholder="Contenu détaillé du cours" required></textarea>
                </div>

                <!-- Travail à Faire -->
                <div class="mb-3">
                    <label for="devoirs" class="form-label">Travail à faire</label>
                    <textarea id="devoirs" name="devoirs" class="form-control" rows="2" placeholder="Travail à faire"></textarea>
                </div>

                <!-- uploader des fichiers  -->
                <div class="mb-3">
                    <label for="formFiles" class="form-label col-md-4 col-form-label ">Uploader des fichiers</label>
                    <!-- <div class="d-flex justify-content-between"> -->
                    <input class="form-control @error('files.*') is-invalid @enderror" type="file" name="files[]" id="formFiles" multiple>
                        @error('files.*')
s                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                </div>

                    <!-- Submit Button -->
                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-success btn-lg">Enregistrer</button>
                    </div>
            </form>
        </div>
    </div>
</div>
@endsection