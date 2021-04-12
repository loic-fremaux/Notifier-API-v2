<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Redirect;

class ProfileController extends Controller
{

    public function index(Request $request): Factory|View|Application
    {
        return view('profile');
    }

    public function resetApiToken(Request $request): Redirector|Application|RedirectResponse
    {
        $request->user()->generateToken();
        return redirect('profile')
            ->with('success', "Réinitialisation du token\rVotre clé d'API a été réinitialisée avec succès.");
    }
}
