<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Seance;
use App\Models\Groupe;
use App\Models\Module;

class SeanceController extends Controller
{
    public function show($id)
    {

        $seances = Seance::join('modules', 'seances.module_id', '=', 'modules.id')
            ->join('groupes', 'seances.groupe_id', '=', 'groupes.id')
            ->join('filieres', 'groupes.filiere_id', '=', 'filieres.id')
            ->select(
                'seances.*',
                'filieres.nom_filiere as filiere_name',
                'groupes.nom_groupe as groupe_name',
                'modules.nom_module as module_name',
            )
            ->where('seances.user_id', $id)
            ->get();

        return view('admin_seance_show', [
            'user_id' => $id,  // This is correct
            'seances' => $seances,
            'title' => 'Emploi du Temps'
        ]);
    }

    public function index($user_id)
    {
        // dd($user_id);
        // $user_id = request()->route('user_id');
        // dd($user_id);
        $seances = Seance::join('modules', 'seances.module_id', '=', 'modules.id')
            ->join('groupes', 'seances.groupe_id', '=', 'groupes.id')
            ->join('filieres', 'groupes.filiere_id', '=', 'filieres.id')
            ->select(
                'seances.*',
                'filieres.nom_filiere as filiere_name',
                'groupes.nom_groupe as groupe_name',
                'modules.nom_module as module_name',
            )
            ->where('seances.user_id', $user_id)
            ->get();
        // $seances = Seance::where('user_id', $id)->get();

        return view('admin_seance_edit', [
            'user_id' =>  $user_id,
            'seances' => $seances,
            'title' => 'Modifier l emploi du Temps'
        ]);
    }

    public function store(Request $request, $user_id)
    {
        // Validez les données
        $request->validate([
            'nom_module' => 'required|exists:modules,nom_module',
            'nom_groupe' => 'required|exists:groupes,nom_groupe',
            'jour' => 'required|string|max:15',
            'h_debut' => 'required|date_format:H:i',
            'h_fin' => 'required|date_format:H:i',
        ]);

        $groupe = Groupe::where('nom_groupe', $request->nom_groupe)->firstOrFail();
        $module = Module::where('nom_module', $request->nom_module)->firstOrFail();

        $days = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'];
        $startTimes = ['08:30', '10:15', '12:00', '13:45', '15:30', '17:15'];
        $endTimes = ['10:00', '11:45', '13:30', '15:15', '17:00', '18:45'];

        if (
            !in_array($request->jour, $days) ||
            !in_array($request->h_debut, $startTimes) ||
            !in_array($request->h_fin, $endTimes)
        ) {
            return redirect()->back()->withErrors(['message' => 'Jour ou horaire invalide.']);
        }

        Seance::create([
            'user_id' => $user_id,
            'module_id' => $module->id,
            'groupe_id' => $groupe->id,
            'jour' => $request->jour,
            'h_debut' => $request->h_debut,
            'h_fin' => $request->h_fin,
        ]);

        return redirect()->route('seance.show', $user_id)->with('success', 'Séance ajoutée avec succès.');
    }

    public function update(Request $request, $id)
    {
        $seance = Seance::findOrFail($id);
        // dd($seance);
        // Validate the incoming request
        $request->validate([
            'nom_module' => 'required|exists:modules,nom_module',
            'nom_groupe' => 'required|exists:groupes,nom_groupe',
            'jour' => 'required|string|max:15',
            'h_debut' => 'required|date_format:H:i',
            'h_fin' => 'required|date_format:H:i|after:h_debut', // Ensure h_fin is after h_debut
        ]);

        $groupe = Groupe::where('nom_groupe', $request->nom_groupe)->firstOrFail();
        $module = Module::where('nom_module', $request->nom_module)->firstOrFail();
        // dd($module);
        // Check for valid days
        $validDays = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'];
        if (!in_array($request->jour, $validDays)) {
            return redirect()->back()->withErrors(['jour' => 'Jour invalide.']);
        }

        // Parse the input times using Carbon
        $startTime = \Carbon\Carbon::parse($request->h_debut);
        $endTime = \Carbon\Carbon::parse($request->h_fin);

        // Ensure that end time is after start time
        if ($endTime <= $startTime) {
            return redirect()->back()->withErrors(['message' => 'L\'heure de fin doit être après l\'heure de début.']);
        }
        // dd($groupe->id);
        // Update the seance
        $seance->update([
            'module_id' => $module->id,
            'groupe_id' => $groupe->id,
            'jour' => $request->jour,
            'h_debut' => $startTime->format('H:i'), // Store time in H:i format
            'h_fin' => $endTime->format('H:i'),   // Store time in H:i format
        ]);

        // Flash success message and redirect to the show page
        session()->flash('success', 'Séance mise à jour avec succès.');
        return redirect()->route('seance.show', $seance->user_id);
    }



    public function destroy($id)
    {
        // Find the Seance by ID
        $seance = Seance::findOrFail($id);

        $user_id = $seance->user_id;
        $seance->delete();

        session()->flash('success', 'Séance supprimée avec succès.');

        return redirect()->route('seance.show', $user_id);
    }
}
