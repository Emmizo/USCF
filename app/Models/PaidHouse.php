<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaidHouse extends Model
{
    use HasFactory;
    protected $fillable=['house_people_id','user_id'];
}
