<?php

namespace App\Http\Controllers;

use App\Models\Groupe;
use App\Models\Filiere;
use Illuminate\Http\Request;

class GroupeController extends Controller
{
    public function index()
    {
        $groupes = Groupe::join('filieres', 'groupes.filiere_id', '=', 'filieres.id')
        ->select('groupes.*',
        'filieres.nom_filiere as filiere_name',
        )->get();
        // Pass the data to the view
        return view('admin_groupe_index', [
            'groupes' => $groupes,
            'title' => 'Gestionnaire des groupes'
        ]);
    }

    // Store a new group
    public function store(Request $request)
    {
        // dd($request);
        // Validate the incoming request
        $request->validate([
            'nom_filiere' => 'required|exists:filieres,nom_filiere', // Ensure the filiere exists in the database
            'nom_groupe' => 'required|string|max:255', // Ensure the group name is valid
        ]);

        // Fetch the filiere based on its name
        $filiere = Filiere::where('nom_filiere', $request->nom_filiere)->first();

        // (Optional but redundant) Check if the filiere exists
        if (!$filiere) {
            session()->flash('error', 'Filière introuvable.');
            return redirect()->route('home');
        }

        // Create the group
        Groupe::create([
            'filiere_id' => $filiere->id,
            'nom_groupe' => $request->nom_groupe,
        ]);

        return redirect()->route('home')->with('success', 'Groupe ajouté avec succès.');
    }

    public function destroy($id)
    {
        $groupe = Groupe::findOrFail($id);

        $groupe->delete();

        return redirect()->route('home')->with('success', 'Groupe Supprimé avec succès.');
    }

    public function update(Request $request, $id)
    {
        $module = Groupe::findOrFail($id);
        // Validate the request
        $request->validate([
            'nom_filiere' => 'required|exists:filieres,nom_filiere', // Ensure the filiere exists in the database
            'nom_groupe' => 'required|string|max:255', // Ensure the module name is valid
        ]);
        $filiere = Filiere::where('nom_filiere', $request->nom_filiere)->first();
        // Check if the filiere exists (this is redundant because of validation, but a safe fallback)
        if (!$filiere) {
            return redirect()->back()->withErrors(['nom_filiere' => 'Filiere introuvable']);
        }

        $module->update([
            'filiere_id' => $filiere->id,
            'nom_groupe' => $request->nom_groupe,
        ]);
        return redirect()->route('home')->with('success', 'groupe mis a jour avec succès.');
    }
}
