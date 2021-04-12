<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;

class FirebaseKey extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'key', 'user_id', 'device_name', 'device_uuid'
    ];

    public static function store(Request $request): FirebaseKey
    {
        $userId = Auth::id();

        $key = FirebaseKey::query()
            ->where("user_id", $userId)
            ->where("device_uuid", $request->device_uuid)
            ->first();

        if ($key === null) {
            $key = new FirebaseKey();
        }

        $key->key = $request->has("firebase_key") ? $request->firebase_key : $key->key;
        $key->user_id = $userId;
        $key->device_name = $request->has("device_name") ? $request->device_name : $key->device_name;
        $key->device_uuid = $request->has("device_uuid") ? $request->device_uuid : $key->device_uuid;

        $key->save();
        $key->refresh();

        return $key;
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
