@extends('layouts.admin')
@section('content')
@include('layouts.message')
<div class="container">
    <div class="row pb-2">
        <h2>{{__('Bienvenue, ') . \Illuminate\Support\Facades\Auth::user()->firstname }}</h2>
    </div>

    <div class="row mb-4">
        <div class="row justify-content-center">
            <div class="col">
                <form class="d-flex" method="GET" action="{{route('search.admin')}}">
                    <div class="input-group">
                        <input class="form-control form-control" type="search" name="item_a_rechercher" placeholder="Rechercher un prof, module, filière, groupe..." aria-label="Search">
                        <button class="btn btn-primary px-4" type="submit">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>



    <div class="row">
        <div class="col me-2">
            <a href="{{ route('register') }}" class="btn btn-primary btn-lg me-4" role="button">Ajouter un professeur</a>
        </div>


        <!-- Module modal button -->
        <div class="col me-2">
            <button type="button" class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#moduleModal">Ajouter un module</button>
        </div>

        <!-- Module modal -->
        <div class="modal fade" id="moduleModal" tabindex="-1" aria-labelledby="moduleMdal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Ajouter un module</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{route('module.store')}}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <!-- Modal body -->
                            <!-- Nom Module -->
                            <div class="mb-3">
                                <label for="titre" class="form-label">Module</label>
                                <input type="text" id="titre" name="nom_module" class="form-control @error('module') is-invalid @enderror" placeholder="Ex: Outils de Developement 1" required autofocus>
                            </div>
                            <!-- nom filière -->
                            <div class="mb-3">
                                <label for="titre" class="form-label">Filière</label>
                                <input type="text" id="titre" name="nom_filiere" class="form-control @error('filiere') is-invalid @enderror" placeholder="Ex: 3IIR" required autofocus>
                                @error('filiere')
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

        <!-- Filiere modal button -->
        <div class="col me-2">
            <button type="button" class="btn btn-primary btn-lg " data-bs-toggle="modal" data-bs-target="#filiereModal">Ajouter une filière</button>

        </div>

        <!-- Filière modal -->
        <div class="modal fade" id="filiereModal" tabindex="-1" aria-labelledby="filiereModal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Ajouter une filière</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{route('filiere.store')}}" method="POST">
                        <div class="modal-body">
                            <!-- Modal body -->
                            <!-- nom filière -->

                            @csrf
                            <div class="mb-3">
                                <label for="nom_filiere" class="form-label">Filière</label>
                                <input type="text" name="nom_filiere" class="form-control @error('nom_filiere') is-invalid @enderror" placeholder="Ex: 3IIR" required autofocus>
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

        <!-- Groupe modal button -->
        <div class="col me-2">
            <button type="button" class="btn btn-primary btn-lg " data-bs-toggle="modal" data-bs-target="#groupeModal">Ajouter un groupe</button>

        </div>

        <!-- Groupe modal -->
        <div class="modal fade" id="groupeModal" tabindex="-1" aria-labelledby="groupeModal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Ajouter un groupe</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{route('groupe.store')}}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <!-- Nom Groupe -->
                            <div class="mb-3">
                                <label for="nom_groupe" class="form-label">Groupe</label>
                                <input type="text" id="nom_groupe" name="nom_groupe" class="form-control @error('nom_groupe') is-invalid @enderror" placeholder="Ex: Groupe 3" required autofocus>
                                @error('nom_groupe')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <!-- Nom Filière -->
                            <div class="mb-3">
                                <label for="nom_filiere" class="form-label">Filière</label>
                                <input type="text" id="nom_filiere" name="nom_filiere" class="form-control @error('nom_filiere') is-invalid @enderror" placeholder="Ex: 3IIR" required autofocus>
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




    </div>
    <div class="row mt-5">
        <div class="d-flex justify-content-between">
            <!-- cahiers ajoutés aujourdhui  -->
            <div class="col-md-6 me-2">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        Cahiers de textes ajoutés aujourd'hui
                    </div>
                    @if($recentCahierTextes->count() > 1)
                    <div class="card-body" style="max-height: 160px; overflow-y: auto;">
                        @else
                        <div class="card-body">
                            @endif
                            @if($recentCahierTextes->isEmpty())
                            <p>Aucun cahier de texte ajoute aujoud hui</p>
                            @else
                            <ul class="list-group">
                                @foreach ($recentCahierTextes as $recentCahierTexte)
                                <li class="list-group-item mb-3">
                                    <div class="d-flex flex-row justify-content-between align-items-start">
                                        <!-- Content Section -->
                                        <div class="content col">
                                            <strong>Professeur :</strong> {{ $recentCahierTexte->user_fn . ' ' . $recentCahierTexte->user_ln }} <br>
                                            <strong>Filière :</strong> {{ $recentCahierTexte->filiere_name }} <br>
                                            <strong>Groupe :</strong> {{ $recentCahierTexte->groupe_name }} <br>
                                            <strong>Module :</strong> {{ $recentCahierTexte->module_name }} <br>
                                            <strong>Date de creation:</strong> {{ $recentCahierTexte->created_at }} <br>
                                        </div>

                                        <!-- Buttons Section -->
                                        <div class="d-flex flex-column ms-auto">
                                            <div class="p-2">
                                                <a role="button" class="btn btn-success text-center d-flex justify-content-center align-items-center" href="">Modifier</a>
                                            </div>
                                            <div class="p-2">
                                                <a role="button" class="btn btn-danger" href="">Supprimer</a>
                                            </div>
                                        </div>
                                    </div>
                                </li>


                                @endforeach
                            </ul>
                            @endif
                        </div>
                    </div>
                </div>
                <!-- Séances Sans Cahier de Texte    -->
                <div class="col-md-6  me-2">
                    <div class="card">
                        <div class="card-header bg-success text-white">
                            Stats géneraux
                        </div>
                        <div class="card-body">
                            <!-- <h5 class="card-title">Module : Intermediate English 1</h5> -->
                            <p class="card-text">
                                <!-- <strong>Nombre total des profs :</strong> 3<br> -->
                                <strong>Nombre total des modules : </strong>{{$moduleCount}}<br>
                                <strong>Nombre total des filières: </strong>{{$filiereCount}}<br>
                                <strong>Nombre total des groupes: </strong>{{$groupeCount}}<br>
                            </p>
                        </div>


                    </div>
                </div>
            </div>
            <!-- <div class="row-md-6 me-3 mt-3">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        Seances a
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            <li class="list-group-item">
                                <strong>Nom :</strong> Réseaux Informatiques 1<br>
                                <strong>Prénom :</strong> 3IIR - 3<br>
                                <strong>E-mail :</strong> blablabla@alalala.com<br>
                                <strong> Horaire :</strong> 12:00 - 13:30 <br>
                                <a href="#" class="btn btn-primary btn-sm mt-2">Ajouter Cahier de Texte</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div> -->

        </div>
    </div>




    @endsection