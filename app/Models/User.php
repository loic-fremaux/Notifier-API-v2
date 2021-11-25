<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'api_token',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function generateToken()
    {
        $this->api_token = Str::random(60);
        $this->save();

        return $this->api_token;
    }

    public static function fromToken(string $token): User
    {
        return User::where('api_token', $token)->first();
    }

    public function services()
    {
        return $this->belongsToMany('App\Models\Service', 'service_members', 'user_id', 'service_id');
    }

    public function apiTokens()
    {
        return $this->hasMany(ApiToken::class);
    }

    public function firebaseKeys()
    {
        return $this->hasMany(FirebaseKey::class);
    }

    public static function fromName($username): ?User
    {
        return User::where('name', $username)->first();
    }

    public static function fromId($input)
    {
        return User::where('id', $input)->first();
    }
}
