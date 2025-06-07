@extends(Auth::user()->is_admin ? 'layouts.admin' : 'layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="row">
            <h2>Données personelles administratives</h2>
        </div>
        <div class="row mt-4">
            <div class="col md-6">
                <table class="table table-borderless table-hover">
                    <tbody>
                        <tr>
                            <th scope="row">Nom</th>
                            <td>{{$user->firstname}}</td>

                            <!-- <td class="d-flex">
                        <a href="/" class="btn btn-success mx-4" role="button">Modifier</a>

                        <form method="POST" action="/">
                            @csrf
                            @method('DELETE') 
                            <button type="submit" class="btn btn-danger">Supprimer</button>
                        </form>
                    </td> -->
                        </tr>
                        <tr>
                            <th scope="row">Prénom</th>
                            <td>{{$user->lastname}}</td>
                        </tr>
                        <tr>
                            <th scope="row">E-mail</th>
                            <td>{{$user->email}}</td>
                        </tr>
                        <tr>
                            <th scope="row">Admin?</th>
                            <td>
                                @if($user->is_admin == 1)
                                Oui
                                @else
                                Non
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>

            </div>
            <div class="col md-2 text-end">
                <img src="{{ $user->pfp ? asset('storage/' . $user->pfp) : asset('img/default-pfp.png') }}"
                    alt="Profile Picture"
                    class="img-thumbnail"
                    style="width: 300px; height: 300px;">
            </div>
        </div>


    </div>
</div>
@endsection