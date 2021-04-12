<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class Service extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'name', 'slug', 'user_id', 'api_key',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'api_key'
    ];

    public static function fromSlug(string $input)
    {
        return Service::where('slug', $input)->first();
    }

    public static function fromApiKey($input)
    {
        return Service::where('api_key', $input)->first();
    }

    public static function store(Request $request): Service
    {
        $userId = Auth::id();

        $service = new Service();

        $service->name = $request->name;
        $service->slug = $request->slug;
        $service->user_id = $userId;
        $service->api_key = Str::random(24);

        $service->save();
        $service->refresh();
        $service->users()->attach([
            'user_id' => $userId
        ]);

        return $service;
    }

    public static function validate(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255|regex:/^(.{5,255})$/',
            'slug' => 'required|unique:services|max:255|regex:/^([a-z-]{5,255})$/',
        ]);
    }

    public function generateToken()
    {
        $this->api_key = Str::random(24);
        $this->save();

        return $this->api_key;
    }

    public function users()
    {
        return $this->belongsToMany('App\Models\User', 'service_members', 'service_id', 'user_id');
    }

    public function addUser(User $newUser)
    {
        foreach ($this->users()->get() as $user) {
            if ($newUser->id === $user->id) {
                return false;
            }
        }

        $this->users()->attach([
            'user_id' => $newUser->id
        ]);
        $this->refresh();
        return true;
    }

    public function delUser(User $targetUser)
    {
        foreach ($this->users()->get() as $user) {
            if ($targetUser->id === $user->id) {
                $this->users()->detach([
                    'user_id' => $targetUser->id
                ]);
                $this->refresh();
                return true;
            }
        }

        return false;
    }
}
