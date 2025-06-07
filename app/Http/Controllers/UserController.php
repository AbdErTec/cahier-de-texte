<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::select('users.*')->get();
        // dd($users);
        return view('admin_prof_index',  ['users' => $users, 'title' => 'Gestionnaire des profs']);
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);

        return view('admin_prof_update', [
            'user' => $user,
            'title' => 'Modifier un professeur'
        ]);
    }
    public function show($id)
    {
        $user = User::findOrFail($id);
        // dd($user->pfp);
        return view('profile', ['user' => $user, 'title' => 'Profil']);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        // Validate the request
        $request->validate([
            // 'module' => 'required|exists:modules,nom_module', // 'modules' is the table name and 'name' is the column
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'email' => $user->email == $request->email ? 'required|email' : 'required|email|unique:users,email',
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'pfp' =>  'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);
        $pfpPath = null;
        if ($user->pfp && \Storage::exists($user->pfp)) {
            \Storage::delete($user->pfp);
        }
        if (request()->hasFile('pfp') && request()->file('pfp')->isValid()) {
            $pfpPath = request()->file('pfp')->store('profile_pictures', 'public'); // Save the file
        }
        // Now you can proceed with storing the Cahier de Texte
        $user->update([
            // 'module_id' => $module->id,
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'password' => $request->password,
            'pfp' => $pfpPath,

            // 'devoirs' => $request->devoirs,
        ]);

        return redirect()->route('user.index')->with('success', 'Professeur mis à jour avec succès');
    }
    public function destroy($id)
    {
        // Find the CahierTexte by ID
        $user = User::findOrFail($id);

        // Delete the CahierTexte record
        $user->delete();

        // Redirect back to the index with a success message
        return redirect()->route('user.index')->with('success', 'Professeur supprimé avec succès');
    }
}
