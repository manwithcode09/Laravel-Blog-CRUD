<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

//class ini sebagai blueprint/template ketika kita ingin membuat user baru
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    
     //fillable artinya, field-field mana saja yang boleh di isi
     //sisanya akan diisi oleh laravel secara otomatis
    // protected $fillable = [
    //     'name',
    //     'username',
    //     'email',
    //     'password',
        
    // ];


    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    //Membuat relasi antara table user dan table post
    public function posts(){
        //kita melihat dari sisi tabel User yang menitipkan foreign-key
        //jadi, satu User bisa memiliki banyak post 
        return $this->hasMany(Post::class);

    }
}
