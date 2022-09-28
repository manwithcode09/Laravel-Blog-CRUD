<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

     //Membuat relasi antara table category dan table post
     public function posts(){
        //kita melihat dari sisi category yang menitipkan foreign-key
        //jadi, satu category bisa memiliki banyak post 
        return $this->hasMany(Post::class);

    }
}
