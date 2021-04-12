<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiToken extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'token', 'user_id', 'usage'
    ];

    public static function store(Request $request): ApiToken
    {
        $userId = Auth::id();

        $key = new ApiToken();

        $key->token = $request->token;
        $key->user_id = $userId;
        $key->usage = $request->usage;

        $key->save();
        $key->refresh();

        return $key;
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public static function userFromToken(string $token): ?User
    {
        if ($token === null) {
            return null;
        }
        $user_id = ApiToken::query()
            ->where("token", $token)
            ->get("user_id")
            ->first()['user_id'];
        return User::fromId($user_id);
    }
}
