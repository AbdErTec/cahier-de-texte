<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |---------------------------------------------------------------------------
    | Register Controller
    |---------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            // If the user is logged in and is not an admin, redirect them
            if (auth()->check() && auth()->user()->is_admin != 1) {
                return redirect('/home');
            }

            // Allow admins to proceed
            return $next($request);
        });
    }
    /**
     * Show the registration form.
     *
     * @return \Illuminate\View\View
     */
    public function showRegistrationForm()
    {
        // Pass a custom title to the view
        $title = 'Ajouter un User ';

        return view('auth.register', compact('title'));
    }
    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(Request $request)
    {
        // Validate the incoming request
        $this->validator($request->all())->validate();

        // Create the new user
        event(new Registered($user = $this->create($request->all())));

        // Log the user in
        $this->guard()->login($user);

        // Check if the user is an admin
        if ($user->is_admin) {
            // If the user is an admin, redirect them to admin_home
            return view('admin_home', [
                'success' => 'Professeur ajouté avec succès',
            ]);
        }

        // Default redirect for non-admin users
        return redirect($this->redirectTo);
    }


    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'is_admin' => ['required', 'boolean'], // Ensure it's a boolean (1 or 0)
            'pfp' =>  'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $pfpPath = null;
        if (request()->hasFile('pfp') && request()->file('pfp')->isValid()) {
            $pfpPath = request()->file('pfp')->store('profile_pictures', 'public'); // Save the file
        }
        return User::create([
            'firstname' => $data['firstname'],
            'lastname' => $data['lastname'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'is_admin' => $data['is_admin'], // Directly store the value
            'pfp' => $pfpPath,
        ]);
    }
}
