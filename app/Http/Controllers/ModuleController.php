<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Module;
use App\Models\Filiere;

class ModuleController extends Controller
{
    // Display the list of modules
    public function index()
    {
        $modules = Module::join('filieres', 'modules.filiere_id','=', 'filieres.id')
        ->select(
            'modules.*',
            'filieres.nom_filiere as filiere_name',
            )->get();
        
        // Pass the data to the view
        return view('admin_module_index', [
            'modules' => $modules,
            'title' => 'Gestionnaire des modules'
        ]);
    }

    // Store a new module
    public function store(Request $request)
    {
        $request->validate([
            'nom_filiere' => 'required|exists:filieres,nom_filiere', // Ensure the filiere exists in the database
            'nom_module' => 'required|string|max:255',
        ]);

        $filiere = Filiere::where('nom_filiere', $request->nom_filiere)->first();
        if (!$filiere) {
            return redirect()->back()->withErrors(['nom_filiere' => 'Filiere introuvable']);
        }

        Module::create([
            'filiere_id' => $filiere->id,
            'nom_module' => $request->nom_module,
        ]);

        return redirect()->route('home')->with('success', 'Module ajouté avec succès.');
    }
    public function destroy($id)
    {
        $module = Module::findOrFail($id);
    
        $module->delete();
    
        return redirect()->route('module.index')->with('success', 'Module Supprimé avec succès.');


    }

    public function update(Request $request, $id) {
        $module = Module::findOrFail($id);
        $request->validate([
            'nom_filiere' => 'required|exists:filieres,nom_filiere', // Ensure the filiere exists in the database
            'nom_module' => 'required|string|max:255', // Ensure the module name is valid
        ]);
        $filiere = Filiere::where('nom_filiere', $request->nom_filiere)->first();
        if (!$filiere) {
            return redirect()->back()->withErrors(['nom_filiere' => 'Filiere introuvable']);
        }

        $module->update([
            'filiere_id' => $filiere->id,
            'nom_module' => $request->nom_module,  
        ]);
        return redirect()->route('home')->with('success', 'Module mis a jour avec succès.');
    }
}