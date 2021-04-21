<?php

namespace App\Http\Controllers\Services;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServicesController extends Controller
{
    public function index(Request $request): Factory|View|Application
    {
        return view('services.list', ['services' => Auth::user()->services()->get()]);
    }

    public function inspect(): Factory|View|Application
    {
        return view('services.inspect');
    }

    public function newService(Request $request)
    {
        return view('services.new');
    }

    public function create(Request $request)
    {
        Service::validate($request);
        $service = Service::store($request);
        return redirect('services')
            ->with('success', "Création de service\rVotre service {$service->name} a bien été ajouté.");
    }

    public function delete(Request $request, $id)
    {
        $service = Service::where(['id' => $id])->first();

        if ($service !== null && $service->user_id === Auth::id()) {
            $service->delete();
            return redirect('services')
                ->with('success', "Suppression de service\rLe service a bien été supprimé.");
        } else {
            return redirect('services')
                ->with('failure', "Suppression de service\rImpossible de supprimer ce service...");
        }
    }

    public function resetApiKey(Request $request, $id)
    {
        $service = Service::where(['id' => $id])->first();

        if ($service !== null && $service->user_id === Auth::id()) {
            $service->generateToken();
            return redirect('services')
                ->with('success', "Réinitialisation de la clé d'API\rLa clé d'API du service {$service->name} a été réinitialisée avec succès.");
        } else {
            return redirect('services')
                ->with('failure', "Réinitialisation de la clé d'API\rImpossible de changer la clé d'API de ce service...");
        }
    }

    public function addMember(Request $request, $id)
    {
        $service = Service::where(['id' => $id])->first();

        if ($service !== null && $service->user_id === Auth::id()) {
            $user = User::fromName($request->input('username'));
            if ($user === null) {
                return redirect('services')
                    ->with('failure', "Ajouter un nouveau membre\rL'utilisateur n'existe pas.");
            }

            if ($service->addUser($user)) {
                return redirect('services')
                    ->with('success', "Ajouter un nouveau membre\r{$user->name} a bien été ajouté au service {$service->name}");
            } else {
                return redirect('services')
                    ->with('warning', "Ajouter un nouveau membre\rL'utilisateur a déjà été ajouté à ce service.");
            }
        } else {
            return redirect('services')
                ->with('failure', "Ajouter un nouveau membre\rImpossible d'ajouter l'utilisateur à ce service.");
        }
    }

    public function removeMember(Request $request, $id, $userId)
    {
        $service = Service::where(['id' => $id])->first();

        if ($service !== null && $service->user_id === Auth::id()) {
            $user = User::fromId($userId);
            if ($user === null) {
                return redirect('services')
                    ->with('failure', "Retirer un membre\rL'utilisateur n'existe pas.");
            }

            if ($user->id === $service->user_id) {
                return redirect('services')
                    ->with('failure', "Retirer un membre\rVous êtes le propriétaire de ce service.");
            }

            if ($service->delUser($user)) {
                return redirect('services')
                    ->with('success', "Retirer un membre\r{$user->name} a bien été retiré au service {$service->name}");
            } else {
                return redirect('services')
                    ->with('warning', "Retirer un membre\r{$user->name} ne fait pas partie de ce service.");
            }
        } else {
            return redirect('services')
                ->with('failure', "Retirer un membre\rImpossible de retirer l'utilisateur de ce service.");
        }
    }
}
