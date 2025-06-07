<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Seance;
use App\Models\Module;
use App\Models\Filiere;
use App\Models\Groupe;
use App\Models\CahierTexte;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = auth()->user(); // Récupérer l'utilisateur authentifié

        if ($user->is_admin) {
            // Rediriger l'admin vers la page d'accueil admin
            // dd('wtf?');
            $recentCahierTextes = CahierTexte::join('users', 'cahier_textes.user_id', '=', 'users.id')
                ->join('modules', 'cahier_textes.module_id', '=', 'modules.id')
                ->join('filieres', 'modules.filiere_id', '=', 'filieres.id')
                ->join('groupes', 'groupes.filiere_id', '=', 'filieres.id')
                ->select(
                    'cahier_textes.*',
                    'users.firstname as user_fn',
                    'users.lastname as user_ln',
                    'modules.nom_module as module_name',
                    'filieres.nom_filiere as filiere_name',
                    'groupes.nom_groupe as groupe_name'
                )
                ->whereDate('cahier_textes.created_at', \Carbon\Carbon::today())
                ->orderBy('cahier_textes.created_at', 'asc') // Adjust column for ordering
                ->get();

            // dd($recentCahierTexte);
            $moduleCount = Module::count();
            $filiereCount = Filiere::count();
            $groupeCount = Groupe::count();

            return view('admin_home', [
                'moduleCount' => $moduleCount,
                'filiereCount' => $filiereCount,
                'groupeCount' => $groupeCount,
                'recentCahierTextes' => $recentCahierTextes,
                'title' => 'Tableau de Bord'
            ]);
        }

        // Récupérer toutes les séances de l'utilisateur
        $seances = Seance::join('modules', 'seances.module_id', '=', 'modules.id')
            ->join('groupes', 'seances.groupe_id', '=', 'groupes.id')
            ->join('filieres', 'groupes.filiere_id', '=', 'filieres.id')
            ->select(
                'seances.*',
                'filieres.nom_filiere as filiere_name',
                'groupes.nom_groupe as groupe_name',
                'modules.nom_module as module_name'
            )
            ->where('seances.user_id', $user->id)
            ->get();
        $days = [
            0 => 'Dimanche',
            1 => 'Lundi',
            2 => 'Mardi',
            3 => 'Mercredi',
            4 => 'Jeudi',
            5 => 'Vendredi',
            6 => 'Samedi',
        ];
        $today = $days[now()->dayOfWeek];
        // Récupérer la prochaine séance
        $seanceProchaine = Seance::join('modules', 'seances.module_id', '=', 'modules.id')
            ->join('groupes', 'seances.groupe_id', '=', 'groupes.id')
            ->join('filieres', 'groupes.filiere_id', '=', 'filieres.id')
            ->select(
                'seances.*',
                'filieres.nom_filiere as filiere_name',
                'groupes.nom_groupe as groupe_name',
                'modules.nom_module as module_name'
            )
            ->where('seances.user_id', $user->id)
            ->where('seances.jour', '=', $today)
            ->where('seances.h_debut', '>', now())
            ->orderBy('seances.h_debut', 'asc')
            ->first();
        // 
        // dd($seanceProchaine);


        $seancesEnseignes = Seance::join('modules', 'seances.module_id', '=', 'modules.id')
            ->join('groupes', 'seances.groupe_id', '=', 'groupes.id')
            ->join('filieres', 'groupes.filiere_id', '=', 'filieres.id')
            ->select(
                'seances.*',
                'filieres.nom_filiere as filiere_name',
                'groupes.nom_groupe as groupe_name',
                'modules.nom_module as module_name'
            )
            ->where('seances.user_id', $user->id)
            ->where('seances.jour', '=', $today)
            ->where('seances.h_fin', '>', now())
            ->orderBy('seances.h_debut', 'asc')->get();

        return view('home', [

            'seances' => $seances,
            'seancesEnseignes' => $seancesEnseignes,
            'seanceProchaine' => $seanceProchaine,
            'title' => 'Tableau de Bord',
        ]);
    }
}
