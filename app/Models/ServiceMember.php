<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceMember extends Model
{
    protected $fillable = [
        'id', 'service_id', 'user_id',
    ];
}
