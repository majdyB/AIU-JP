<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    //use HasFactory;
    protected $table = "players";
    protected $fillable = ['fullname','password','email','image','age','height','weight','disease','skill'];
    protected $hidden = [];
    public $timestamps = true;
}
