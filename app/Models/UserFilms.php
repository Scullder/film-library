<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserFilms extends Model
{
    use HasFactory;
    protected $table  = 'UsersFilms';
    public $timestamps = false;
    
}
