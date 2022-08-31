<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class People extends Model
{
    use HasFactory;
    protected $table="peoples";
    protected $fillable=['first_name','last_name','phone','identity','cat_id'];
    
    public function updateStatus($id,$status) {
        return $this->where('id', $id)->update(['status'=>$status]);
     }

     public static function updatePeople($info) {
        $data = [
                                'first_name'=>$info['first_name'],
                                'last_name'=>$info['last_name'],
                                'phone'=>$info['phone'],
                                'identity'=>$info['identity'],
                                'cat_id' => $info['cat_id'],
                                
                ];
       return People::where('id', $info['id'])
                    ->update($data);
    }
}
