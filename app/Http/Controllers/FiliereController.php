<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Filiere;

class FiliereController extends Controller
{
    public function index()
    {
        $filieres = Filiere::select('filieres.*')->get();
        // dd($users);
        foreach ($filieres as $filiere) {
            $modulesCount = $filiere->modules()->count();
        }

        return view('admin_filiere_index',  [
            'modulesCount' => $modulesCount,
            'filieres' => $filieres,
            'title' => 'Gestionnaire de filières'
        ]);
    }

    public function store(Request $request)
    {
        // dd($request);
        $filiere = Filiere::where('nom_filiere', $request->nom_filiere)->first();

        if ($filiere) {
            return redirect()->route('home')->with('error', 'Filière existe déjà');
        }
        // Validate the request
        $request->validate([
            'nom_filiere' => 'required|string|max:30',
        ], [
            'nom_filiere.unique' => 'Filière existe déjà',  // Custom error message for unique validation
        ]);

        Filiere::create([
            'nom_filiere' => $request->nom_filiere,
        ]);

        return redirect()->route('home')->with([
            'success' => 'Filière ajoutée avec succès!',
            'title' => 'Tableau de Bord',
        ]);
    }

    public function update(Request $request, $id)
    {
        $filiere = Filiere::findOrFail($id);
        // Validate the request
        $request->validate([
            'nom_filiere' => 'required|string|max:30',
        ], [
            'nom_filiere.unique' => 'Filière existe déjà',  // Custom error message for unique validation
        ]);

        $filiere->update([
            'nom_filiere' => $request->nom_filiere,
        ]);

        return redirect()->route('filiere.index')->with('success', 'Filière mis à jour avec succès');
    }


    public function destroy($id)
    {

        $filiere = Filiere::findOrFail($id);

        $filiere->delete();
        return redirect()->route('filiere.index')->with('success', 'Filière supprimé avec succès');
    }
}
