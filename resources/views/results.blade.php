@extends(Auth::user()->is_admin ? 'layouts.admin' : 'layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <h3>Résultats de la recherche</h3>
    </div>
    <div class="row">
        @if(empty($resultats) || collect($resultats)->flatten()->isEmpty())
        <div class="row text-center">
            <strong>Aucun résultat</strong>
        </div>
        @else
        <table class="table table-responsive">
            <!-- <thead>
                <tr>
                    <th>Type</th>
                    <th>Name</th>
                </tr>
            </thead> -->
            <tbody>
                {{-- Display modules --}}
                @if($resultats['modules']->isNotEmpty())
                <tr>
                    <td colspan="2"><strong>Modules</strong></td>
                </tr>
                @foreach ($resultats['modules'] as $module)
                <tr>
                    <td>Module</td>
                    <td>{{ $module->nom_module }}</td>
                </tr>
                @endforeach
                @endif

                {{-- Display groupes --}}
                @if($resultats['groupes']->isNotEmpty())
                <tr>
                    <td colspan="2"><strong>Groupes</strong></td>
                </tr>
                @foreach ($resultats['groupes'] as $groupe)
                <tr>
                    <td>Groupe</td>
                    <td>{{ $groupe->nom_groupe }}</td>
                </tr>
                @endforeach
                @endif

              
                @if($resultats['users']->isNotEmpty())
                <tr>
                    <td colspan="2"><strong>Users</strong></td>
                </tr>
                @foreach ($resultats['users'] as $user)
                <tr>
                    <td>User</td>
                    <td>{{ $user->firstname }} {{ $user->lastname }}</td>
                </tr>
                @endforeach
                @endif
                
                
                @if($resultats['filieres']->isNotEmpty())
                <tr>
                    <td colspan="2"><strong>Filieres</strong></td>
                </tr>
                @foreach ($resultats['filieres'] as $filiere)
                <tr>
                    <td>Filiere</td>
                    <td>{{ $filiere->nom_filiere }}</td>
                </tr>
                @endforeach
                @endif
            </tbody>
        </table>
        @endif
    </div>
</div>
@endsection
