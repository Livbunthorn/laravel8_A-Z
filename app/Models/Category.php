<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{

    //softDelete use for auto creeate field in database(created_at, updated_at, deleted_at)
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'category_name',
    ];   
     public function user()    {
        return $this->hasOne(User::class , 'id', 'user_id');    }
}
