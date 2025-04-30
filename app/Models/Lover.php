<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lover extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'pass',
        'profile_text',
        'content',
        'letter_text',
        'avatar_url',
        'picture1',
        'picture2',
        'picture3',
        'picture4',
        'picture5',
        'picture6',
        'picture7',
        'picture8',
        'picture9'
    ];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    
}
