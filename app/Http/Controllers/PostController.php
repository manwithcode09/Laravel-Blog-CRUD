<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\User;
use App\Models\Post;
use Illuminate\Http\Request;


//class yg akan menerima data dari Routes, dan mengirim ke Models
class PostController extends Controller
{
    public function index() {

        $title = '';
        
        if(request('category')){
            $category = Category::firstWhere('slug', request('category'));
            $title = 'in ' . $category->name;
        }


        if(request('author')){
            $author = User::firstWhere('username', request('author'));
            $title = 'by ' . $author->name;
        }


        return view('posts', [
            "title" => "All Posts " . $title,
            "active" => "posts",
            // "posts" => Post::all()
            //method filter akan mengirim data request kedalam model
            //jika tidak ada rquest, langsung jalankan get
            // latest : akan mencari data yang paling baru
            "posts" => Post::latest()->filter(request(['search', 'category','author']))->paginate(7)->withQueryString()
            
        ]);
    }

    //Route model binding (type-hinting:memaksakan sebuah method untuk menerima parameter berupa object)
    //jadi data yang dikirimkan dari Route ke dalam controller akan di ikat dengan model(Post)
    //dan ini berarti varible($post) yang dikirim dari Route memiliki nilai utuh dari modelnya (Post)
    //dan lagi, nama varibale yang menerima nilai(parameter) harus sama dengan nama varible yang mengirim (Routes)
    public function show(Post $post) {

        return view('post', [
            "title" => "Single Post",
            "active" => "posts", 
            "post" => $post
        ]);

    }

}
