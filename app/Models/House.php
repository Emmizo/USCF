<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class House extends Model
{
    use HasFactory;
    protected $fillable=['id','house_code','cell_id','paid'];
    
    public function updateStatus($id,$status) {
        return $this->where('id', $id)->update(['is_taken'=>$status]);
     }
     public function deleteHouse($id) {
        return $this->where('id', $id)->update(['is_deleted'=>1]);
     }
}
