<?php

namespace App\Http\Controllers;

use App\Mail\NotificationEmail;
use App\Models\Service;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ApiNotificationController extends Controller
{
    private string $serverKey;

    public function __construct()
    {
        $this->serverKey = config('app.firebase_key');
    }

    public function push(Request $request): Application|ResponseFactory|Response|JsonResponse
    {
        if ($request->input('service_key') === null) {
            return response()->json([
                "message" => "service not found",
            ], 404);
        }

        $service = Service::fromApiKey($request->input('service_key'));

        if ($service === null) {
            return response([
                "message" => "service not found",
            ], 404);
        }

        $found = false;
        foreach ($service->users()->get() as $user) {
            if ($user->id === Auth::id()) {
                $found = true;
                break;
            }
        }

        if (!$found) {
            return response([
                "message" => "provided api keys doesn't belong to an user in the service",
            ], 403);
        }

        foreach ($service->users()->get() as $user) {
            Mail::to($user)->send(new NotificationEmail($request->input('title') ?? 'ALERTE', $request->input('body') ?? $request->message));
        }

        return $this->sendPush($service->users()->get(), $request);
    }

    public function sendPush($users, Request $request)
    {
        $data = [
            "registration_ids" => array_merge(...$users->map(function ($user) {
                return $user->firebaseKeys()->get()->map(function ($key) {
                    return $key->key;
                });
            })->toArray()),
            "notification" =>
                [
                    "title" => $request->input('title') ?? 'ALERTE',
                    "body" => $request->input('body') ?? $request->message,
                    "icon" => $request->input('icon')
                ],
        ];
        $dataString = json_encode($data);

        $headers = [
            'Authorization: key=' . $this->serverKey,
            'Content-Type: application/json',
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

        return response()->json([
            'status' => 'Notification sent !',
            'returned' => curl_exec($ch),
            'data' => $data,
        ], 200);

    }
}
