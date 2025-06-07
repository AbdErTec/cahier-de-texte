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
                @if($resultats['cahier_textes']->isNotEmpty())
                <tr>
                    <td colspan="2"><strong>Cahiers de Textes</strong></td>
                </tr>
                @foreach ($resultats['cahier_textes'] as $cdt)
                <tr>
                    <td>Cahier de Texte</td>
                    <td>{{ $cdt->titre }}</td>
                    <td>{{ $cdt->date }}</td>
                </tr>
                @endforeach
                @endif
            </tbody>
        </table>
        @endif
    </div>
</div>
@endsection
