<?php

namespace App\Http\Controllers;

use App\Models\ApiToken;
use App\Models\FirebaseKey;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiTokenController extends Controller
{
    public function index(Request $request): Factory|View|Application
    {
        return view('api', ["tokens" => Auth::user()->apiTokens()->get()]);
    }

    public function delete(Request $request, $id)
    {
        $key = ApiToken::where(['id' => $id])->first();

        if ($key !== null && $key->user_id === Auth::id()) {
            $key->delete();
            return redirect('api')
                ->with('success', "Suppression de clé api\rLa clé a bien été supprimée.");
        } else {
            return redirect('api')
                ->with('failure', "Suppression de clé api\rImpossible de supprimer cette clé...");
        }
    }
}
