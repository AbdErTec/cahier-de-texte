@extends('layouts.admin')
@section('content')
@include('layouts.message')

<div class="container py-4">
    <div class="row">
        <h2>Gestionnaire des professeurs</h2>
    </div>


    <div class="row mt-5">
        @if($users->isEmpty())
        <div class="row text-center">
            <strong>Aucun professeur</strong>
        </div>
        @else
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">Nom</th>
                    <th scope="col">Prénom</th>
                    <th scope="col">E-mail</th>
                    <th scope="col">Admin?</th>
                    <!-- <th scope="col">Actions</th> -->
                    <!-- <th scope="col">Date</th> -->
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr>
                    <td>{{ $user->firstname }}</th> <!-- Fixed 'firsname' typo -->
                    <td>{{ $user->lastname }}</td> <!-- Fixed 'lasname' typo -->
                    <td>{{ $user->email }}</td>
                    <td>
                        @if($user->is_admin == 1)
                        Oui
                        @else
                        Non
                        @endif
                    </td>
                    <td class="d-flex ">
                    <a href="{{ route('seance.show', $user->id) }}" class="btn btn-primary">Emploi du Temps</a>
                    <a href="{{ route('user.edit', $user->id) }}" class="btn btn-success mx-4" role="button">Modifier</a>

                        <form method="POST" action="{{ route('user.destroy', $user->id) }}">
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