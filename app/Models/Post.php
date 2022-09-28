<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Post extends Model
{
    use HasFactory;

    //slugable => pembuat slug otomatis
    //slugable bisa dipakai berdasarkan model mana yg membutuhkannya, dalam kasus ini model post
    use Sluggable;
    

    // fillable untuk field yang boleh di isi, yg tidak ada didalamnya berarti tidak boleh diisi 
    // protected $fillable = ['title', 'excerpt', 'body'];
    
    // guarded untuk field yang tidak boleh di isi, yg tidak ada didalamnya berarti boleh diisi 
    protected $guarded = ['id'];

    // with ini akan ikut terbawa setiap kali Post di panggil
    //menggunakan teknik eager load untuk menghindari N+1 problem
    protected $with = ['category', 'author'];

    //Membuat relasi antara table post dan table category
    public function category(){
        //Mendefinisikan Kebalikan dari Hubungan (inverse, pakai belongsTo)
        //kita melihat dari sisi post
        //jadi, satu post hanya memiliki satu category (one-to-one inverse)
        return $this->belongsTo(Category::class);
    }


    //Membuat relasi antara table post dan table user
    public function author(){

        //Mendefinisikan Kebalikan dari Hubungan (inverse, pakai belongsTo)
        //kita melihat dari sisi post
        //jadi, satu post hanya memiliki satu user (one-to-one inverse)
        //membuat alias untuk table user_id menjadi author(pada method)
        return $this->belongsTo(User::class,'user_id'); 

    }

    //method untuk query pencarian data
    public function scopeFilter($query, array $filters) {
      
        // menggunakan when method ketika first argumen bernilai true
        // menggunakan null coalesing untuk menggantikan penulisan dengan issset
        
        /*pada callback, query pada parameter pertama akan dijalankan terlebih dahulu
          lalu hasilnya akan di tampung pada variable pada parameter kedua
         */
        $query->when($filters['search'] ?? false, function($query, $cari){

        //jalankan query () / melanjutkan chaining
         return $query->where('title', 'like', '%' . $cari. '%')
                      ->orWhere('body', 'like', '%' . $cari . '%');

        });

        //filter untuk tabel category
        $query->when($filters['category'] ?? false, function($query, $category){

            //wherehas berarti memiliki relasi ke tabel yg dituju
            //use untuk memakai nilai dari variable yg berada diluar jangkauan dari method 
            return $query->whereHas('category', function($query) use ($category){ 
                   $query->where('slug', $category);

            });
        });

        
        //filter untuk tabel user(author)
        $query->when($filters['author'] ?? false, function($query, $author){

            //wherehas berarti memiliki relasi ke tabel yg dituju
            //use untuk memakai nilai dari variable yg berada diluar jangkauan dari method 
            return $query->whereHas('author', function($query) use ($author){ 
                   $query->where('username', $author);

            });
        });
    }

    //Kustom key
    //ketika menggunakan resource controller, id akan menjadi nilai default yang dipakai untuk menampilkan data 
    //akan menggunakan kolom yang lain didalam database selain id (secara default)
    //tuliskan methodnya didalam model, lalu lakukan route model binding pada routenya
    //cara ini akan menimpa nilai id secara default pada semua route
    public function getRouteKeyName() {
        
        return 'slug';
    }

    //implement trait slugable untuk membuat slug otomatis
    public function sluggable(): array
    {
        return [
            'slug' => [
                //jadi slug akan dibuat berdasarkan kolom title (yg ada didalam database)
                'source' => 'title'
            ]
        ];
    }

}
