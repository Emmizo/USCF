<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeopleHouse extends Model
{
    use HasFactory;
    protected $table = 'house_peoples';
    protected $fillable=['house_id','people_id'];
}
