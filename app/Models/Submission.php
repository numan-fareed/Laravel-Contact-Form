<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'email', 
        'phone', 
        'message', 
        'street', 
        'state', 
        'zip', 
        'country', 
        'image_paths', 
        'file_paths'
    ];

    protected $casts = [
        'image_paths' => 'array',
        'file_paths' => 'array'
    ];
}
