<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Module;
use App\Models\Groupe;
use App\Models\Filiere;
use App\Models\User;
use App\Models\CahierTexte;

class SearchController extends Controller
{
    public function indexAdmin(Request $request) {
        // dd('GRTIT');
        $item_a_rechercher = $request->input('item_a_rechercher');
        $resultats = [
            'modules' => Module::where('nom_module', 'like', '%'. $item_a_rechercher . '%')->get()    ,
            'filieres' => Filiere::where('nom_filiere', 'like', '%'. $item_a_rechercher . '%')->get(),
            'groupes' => Groupe::where('nom_groupe', 'like', '%'. $item_a_rechercher . '%')->get(),
            'users' => User::where('firstname', 'like', '%'. $item_a_rechercher . '%')->orWhere('lastname', 'like', '%'. $item_a_rechercher . '%')->get(),
            'cahier_textes' => CahierTexte::where('titre', 'like', '%'. $item_a_rechercher . '%')->get(),
        ];

        return view('results', [
            'resultats' =>$resultats,
            'title' => 'Resultats de la recherche',
        ]);
    }

    public function indexUser(Request $request) {
        $user = auth()->user();
        // dd('GRTIT');
        $item_a_rechercher = $request->input('item_a_rechercher');
        $resultats = [
            // 'modules' => Module::where('nom_module', 'like', '%'. $item_a_rechercher . '%')
            // ->where('users.id','=', $user->id)
            // ->get()    ,
            // 'filieres' => Filiere::where('nom_filiere', 'like', '%'. $item_a_rechercher . '%')
            // ->where('users.id','=', $user->id)
            // ->get(),
            // 'groupes' => Groupe::where('nom_groupe', 'like', '%'. $item_a_rechercher . '%')
            // ->where('users.id','=', $user->id)
            // ->get(),
            // 'users' => User::where('firstname', 'like', '%'. $item_a_rechercher . '%')->orWhere('lastname', 'like', '%'. $item_a_rechercher . '%')->get(),
            'cahier_textes' => CahierTexte::where('titre', 'like', '%'. $item_a_rechercher . '%')
            ->where('cahier_textes.user_id','=', $user->id)
            ->get(),
        ];

        return view('results_user', [
            'resultats' =>$resultats,
            'title' => 'Resultats de la recherche',
        ]);
    }
}
