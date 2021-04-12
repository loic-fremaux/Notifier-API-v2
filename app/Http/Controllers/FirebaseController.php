<?php

namespace App\Http\Controllers;

use App\Models\ApiToken;
use App\Models\FirebaseKey;
use App\Models\Service;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class FirebaseController extends Controller
{
    public function index(Request $request): Factory|View|Application
    {
        return view('firebase', ["keys" => Auth::user()->firebaseKeys()->get()]);
    }

    public function delete(Request $request, $id)
    {
        $key = FirebaseKey::where(['id' => $id])->first();

        if ($key !== null && $key->user_id === Auth::id()) {
            $key->delete();
            return redirect('firebase')
                ->with('success', "Suppression de clé firebase\rLa clé a bien été supprimée.");
        } else {
            return redirect('firebase')
                ->with('failure', "Suppression de clé firebase\rImpossible de supprimer cette clé...");
        }
    }

    public function registerDevice(Request $request): Application|ResponseFactory|Response
    {
        FirebaseKey::store($request);

        $key = new ApiToken();

        $key->token = Str::random(128);
        $key->user_id = Auth::id();
        $key->usage = trans("app.phone") . $request->device_name;

        $key->save();
        $key->refresh();

        return response([
            "message" => "device successfully registered",
            "api_token" => $key->token,
        ], 200);
    }

    public function updateDevice(Request $request): Response|Application|ResponseFactory
    {
        $key = FirebaseKey::query()
            ->where("user_id", Auth::id())
            ->where("device_uuid", $request->device_uuid)
            ->first();

        if ($key === null) return response([
            "message" => "key not found",
        ], 404);

        $key->key = $request->key;
        $key->save();
        $key->refresh();

        return response([
            "message" => "device successfully updated",
            "api_token" => $key->token,
        ], 200);
    }
}
