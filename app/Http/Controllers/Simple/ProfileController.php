<?php

namespace App\Http\Controllers\Simple;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth, Hash};
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        return view('simple.profile.show', compact('user'));
    }

    public function edit()
    {
        $user = Auth::user();
        return view('simple.profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:100'],
            'pseudo'   => ['required', 'string', 'max:50', 'regex:/^[a-zA-Z0-9_\-]+$/', Rule::unique('users')->ignore($user->id)],
            'email'    => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => ['nullable', 'min:8', 'confirmed'],
        ]);

        $user->name = $validated['name'];
        $user->pseudo = $validated['pseudo'];
        $user->email = $validated['email'];
        
        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }
        
        $user->save();

        return redirect()->route('simple.profile.show')->with('success', 'Votre profil a été mis à jour avec succès.');
    }

    // Vue publique pour voir le profil des autres membres
    public function showPublic($pseudo)
    {
        $user = User::where('pseudo', $pseudo)->firstOrFail();
        return view('simple.profile.public', compact('user'));
    }
}