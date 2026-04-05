<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\ExperienceService;
use Illuminate\Http\{Request, RedirectResponse};
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class AdminUserController extends Controller
{
    public function __construct(private ExperienceService $xpService) {}

    // ─────────────────────────────────────────────────────────
    // INDEX — Liste de tous les utilisateurs (avec recherche)
    // ─────────────────────────────────────────────────────────
    public function index(Request $request)
    {
        $query = User::query();

        // Barre de recherche (par nom, email ou pseudo)
        if ($request->filled('search')) {
            $searchTerm = '%' . $request->search . '%';
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', $searchTerm)
                  ->orWhere('email', 'like', $searchTerm)
                  ->orWhere('pseudo', 'like', $searchTerm);
            });
        }

        // Filtre par rôle
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $users = $query->latest()->paginate(20)->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    // ─────────────────────────────────────────────────────────
    // PENDING — Liste des utilisateurs en attente de validation
    // ─────────────────────────────────────────────────────────
    public function pending()
    {
        $users = User::pendingApproval()->latest()->paginate(20);
        return view('admin.users.pending', compact('users'));
    }

    // ─────────────────────────────────────────────────────────
    // APPROVE — Valider un compte
    // ─────────────────────────────────────────────────────────
    public function approve(User $user): RedirectResponse
    {
        $user->is_approved = true;
        $user->approved_at = now();
        $user->approved_by = Auth::id();
        $user->save();
        
        // SÉCURITÉ & CAHIER DES CHARGES : Envoi d'un e-mail de validation
        try {
            Mail::raw("Bonjour {$user->name},\n\nExcellente nouvelle : votre compte a été validé par notre administrateur ! Vous pouvez dès à présent vous connecter sur la plateforme Chez Léon pour accéder à vos objets connectés.\n\nÀ très vite !", function ($message) use ($user) {
                $message->to($user->email)
                        ->subject('✅ Votre compte Chez Léon est validé !');
            });
        } catch (\Exception $e) {
            // On attrape l'erreur si le serveur mail n'est pas configuré
            // pour ne pas bloquer l'administrateur
        }
        
        return back()->with('success', "Le compte de {$user->name} a été approuvé. Un e-mail lui a été envoyé.");
    }

    // ─────────────────────────────────────────────────────────
    // ADJUST XP — Ajouter ou retirer manuellement de l'XP
    // ─────────────────────────────────────────────────────────
    public function adjustXp(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'delta'  => ['required', 'integer', 'min:-5000', 'max:5000'],
            'reason' => ['required', 'string', 'max:255']
        ]);

        $this->xpService->adminAdjust($user, $validated['delta'], $validated['reason'], Auth::user());
        
        return back()->with('success', "L'expérience de {$user->name} a été ajustée de {$validated['delta']} XP.");
    }
}