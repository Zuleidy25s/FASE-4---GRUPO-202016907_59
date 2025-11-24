<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory;

    protected $dates = ['delete_at'];
    protected $table = 'user_favorites';
    protected $hidden = ['created_at', 'updated_at'];
}
