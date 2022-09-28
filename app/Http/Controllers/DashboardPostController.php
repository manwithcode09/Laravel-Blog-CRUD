<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use \Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
/**
 * Resource Controllers barfungsi untuk manangani aktivitas CRUD pada laravel
 */

class DashboardPostController extends Controller
{
    /**
     * Menampilkan semua data (post) berdasarkan user tertentu.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
    
        return view('dashboard.posts.index', [

                 //menampilkan post berdasarkan id user yang sedang login
                'posts' => Post::where('user_id', auth()->user()->id)->get()
        ]);

    }
    

    /**
     * Fungsi lihat (detail) dari sebuah post.
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post) {
        
        return view('dashboard.posts.show', [

            'post' => $post
        ]);
    }


    /**
     * Menampilkan halaman tambah data (post).
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('dashboard.posts.create', [
            //menampilkan seluruh
            'categories' => Category::all()
        ]);
    }

    /**
     * Menjalankan fungsi tambah data.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * untuk image, kita harus menggunakan symbolic link untuk menghubungkan folder storage dengan 
     * folder public  
     */ 
    public function store(Request $request) {
        
        
        // proses validasi data yang akan ditambahkan
        $validateData = $request->validate([

                'title' => 'required|max:255',
                'slug' =>  'required|unique:posts',
                'category_id' => 'required',
                'image' => 'image|file|max:1024',
                'body' => 'required'
        ]);

        // cek image, jika user upload gambar, maka ambil dan simpan data gambar
        //jika tidak, maka pakai gambar dari API unsplash
        if($request->file('image')){
           
            $validateData['image'] = $request->file('image')->store('post-images');
        }

        $validateData['user_id'] = auth()->user()->id;
        // limit string excerpt dengan str::limit
        // strip_tags fungsi php digunakan untuk menghilangkan tag html
        $validateData['excerpt'] = Str::limit(strip_tags($request->body), 200);

        Post::create($validateData);

        return redirect('/dashboard/posts')->with('success', 'New post has been added!');

    }

    /**
     * Menampilkan halaman ubah data ( edit post).
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post){
        
        return view('dashboard.posts.edit', [

            'post' => $post,
            'categories' => Category::all()

        ]);
        
    }

    /**
     * Menjalankan fungsi ubah data (edit post).
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    //$request adalah data baru kita yang ditulis, sedangkan $post adalah data lama yg sudah ada di database
    public function update(Request $request, Post $post) {

        // proses validasi data yang akan ditambahkan
        $rules = [

        'title' => 'required|max:255',
        'category_id' => 'required',
        'image' => 'image|file|max:1024',
        'body' => 'required'
    ];

        //slug harus melewati validasi yg berbeda, karna data slug yang seblumnya sudah ada di database
        //dan slug ini bersifat unik, jadi tidak boleh ada duplikat data slug yg sama
        //jika slug yg baru tidak sama dengan slug yang lama
        if($request->slug != $post->slug){
            // maka timpa data rules dengan data slug yg baru, dan masuk ke dalam validasi
            $rules['slug'] = 'required|unique:posts';
        }

        //jika sama, maka lakukan validasi tanpa melibatkan $rules['slug']
        $validateData = $request->validate($rules);

        // cek apakah user upload gambar yang baru
        if($request->file('image')){
            //jika ada gambar baru, maka ketika di upload sekalian, menghapus gambar lama di dalam storage
            if($request->oldImage) {

                Storage::delete($request->oldImage);
            }
            
            $validateData['image'] = $request->file('image')->store('post-images');
        }

        $validateData['user_id'] = auth()->user()->id;
        
        $validateData['excerpt'] = Str::limit(strip_tags($request->body), 200);


        // update data berdsarkan id post
        Post::where('id', $post->id)->update($validateData);

        return redirect('/dashboard/posts')->with('success', 'Post has been updated!');
    }

    /**
     * Fungsi untuk menghapus data (post).
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post) {
         
        //jika ada gambar, maka hapus
        if($post->image) {

         Storage::delete($post->image);
        }
    
        // Data akan dihapus berdasarkan id post
        Post::destroy($post->id);
        return redirect('/dashboard/posts')->with('success', 'Post has been Deleted!');


    }


    public function checkSlug(Request $request) {

        //create slug mengambil dari class/model post
        //lalu mengambil field slug
        //lalu mengambil nilai title dari request fetch title (js)
        //dan variable slug akan berisi apapun hasilnya
        $slug = SlugService::createSlug(Post::class, 'slug', $request->title);

        //lalu kembalikan sebagai response json, agar dapat diolah oleh method json yg ada didalam fetch
        return response()->json(['slug' => $slug]); 

    }
}
