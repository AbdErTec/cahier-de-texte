<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Module;
use App\Models\cahierTexte;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class CahierTexteController extends Controller
{
    public function index()
    {
        // $user = auth()->user();
        // $cahierTextess = CahierTexte::where('user_id', Auth::id())->get();
        // dd($cahierTextess);
        $cahierTextes = CahierTexte::join('users', 'cahier_textes.user_id', '=', 'users.id')
            ->join('modules', 'cahier_textes.module_id', '=', 'modules.id')
            ->join('filieres', 'modules.filiere_id', '=', 'filieres.id')
            ->join('groupes', 'groupes.filiere_id', '=', 'filieres.id')
            ->select(
                'cahier_textes.*',
                'modules.nom_module as module_name',
                'filieres.nom_filiere as filiere_name',
                'groupes.nom_groupe as groupe_name'
            )
            ->where('cahier_textes.user_id', Auth::id())
            ->get();
        // dd(Auth::id());
        // dd($cahierTextes);
        // dd($cahierTextes);
        return view('cahier_texte_index', [
            'cahierTextes' => $cahierTextes, // Correct
            'title' => 'Mes Cahiers'
        ]);
        
    }

    public function downloadPDF($id) {
        $cahierTexte = CahierTexte::findorFail($id);
        $pdf = PDF::loadView('cahier_texte_render', ['cahierTexte' => $cahierTexte]);
        return $pdf->download('cahier_de_texte_' . $cahierTexte->date . '.pdf');
        
    }

    public function create()
    {
        return view('cahier_texte_create', ['title' => 'Nouveau Cahier']);
    }

    public function store(Request $request)
    {
        // dd($request->files);
        // Validate the request
        $request->validate([
            'module' => 'required|exists:modules,nom_module', // 'modules' is the table name and 'name' is the column
            'date_seance' => 'required|date',
            'titre' => 'required|string|max:255',
            'objectifs' => 'required|string',
            'contenu' => 'required|string',
            'devoirs' => 'nullable|string',
            'files' => 'nullable|array|max:5',
            'files.*' => 'file|mimes:pdf,doc,docx,zip,png,jpeg,jpg,mp4,mp3,wav,txt,csv,xlsx,xlsm|max:10240',  // Correct mime types list
        ]);

        $module = Module::where('nom_module', $request->module)->first();

        $filesPaths = [];
        if (request()->hasFile('files') && request()->file('files')[0]->isValid()) {
            foreach (request()->file('files') as $file) {
                // Sauvegarder chaque fichier dans un dossier spécifique
                $filesPaths[] = $file->store('uploaded_files', 'public');
            }
        }
        // dd($filesPaths);
        CahierTexte::create([
            'user_id' => auth()->id(),
            'module_id' => $module->id,
            'date' => $request->date_seance,
            'titre' => $request->titre,
            'objectifs' => $request->objectifs,
            'contenu' => $request->contenu,
            'devoirs' => $request->devoirs,
            'fichier' => json_encode($filesPaths),
        ]);

        return redirect()->route('cahierTexte.index')->with('success', 'Cahier de texte ajouté avec succès');
    }

    public function destroy($id)
    {
        $cahierTexte = CahierTexte::findOrFail($id);

        // Delete the CahierTexte record
        $cahierTexte->delete();

        return redirect()->route('cahierTexte.index')->with('success', 'Cahier de texte supprimé avec succès');
    }
    public function edit($id)
    {
        $cahierTexte = CahierTexte::findOrFail($id);
        $module = Module::where('id', $cahierTexte->module_id)->first();
        // $files = json_decode($cahierTexte->fichier, true);
        return view('cahier_texte_update', [
            'cahierTexte' => $cahierTexte,
            'nom_module' => $module->nom_module, // Pass the results to the view
            // 'files'=>$files,
            'title' => 'Modifier un cahier'
        ]);
    }
    public function update(Request $request, $id)
    {
        $cahierTexte = CahierTexte::findOrFail($id);
        // Validate the request
        $request->validate([
            'module' => 'required|exists:modules,nom_module', // 'modules' is the table name and 'name' is the column
            'date_seance' => 'required|date',
            'titre' => 'required|string|max:255',
            'objectifs' => 'required|string',
            'contenu' => 'required|string',
            'devoirs' => 'nullable|string',
            'files' => 'nullable|array|max:5',
            'files.*' => 'file|mimes:pdf,doc,docx,zip,png,jpeg,jpg,mp4,mp3,wav,txt,csv,xlsx,xlsm|max:10240',  // Correct mime types list
        ]);

        // Fetch the module ID
        $module = Module::where('nom_module', $request->module)->first();

        $currentFiles = json_decode($cahierTexte->fichier, true); // Decode the current file paths

        // If there are files to remove, remove them from the current files first
        if ($request->has('remove_files')) {
            $filesToRemove = $request->remove_files; // An array of file paths to remove
            $currentFiles = array_diff($currentFiles, $filesToRemove); // Remove the files from the current list
        }

        // Handle new files
        $newFiles = [];
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                // Save each new file and get its path
                $newFiles[] = $file->store('uploaded_files', 'public');
            }
        }

        // Merge the remaining current files with the new files (if any)
        $allFiles = array_merge($currentFiles, $newFiles);
        $cahierTexte->update([
            'module_id' => $module->id,
            'date' => $request->date_seance,
            'titre' => $request->titre,
            'objectifs' => $request->objectifs,
            'contenu' => $request->contenu,
            'devoirs' => $request->devoirs,
            'fichier' => json_encode($allFiles),
        ]);

        return redirect()->route('cahierTexte.index')->with('success', 'Cahier de texte mis à jour avec succès');
    }
}
