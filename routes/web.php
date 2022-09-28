<?php

use App\Http\Controllers\AdminCategoryController;
use App\Models\Category;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DashboardPostController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|--------------------------------------------------------------------------
| 
| - ROUTES digunakan untuk mengirim data ke dalam class yang ada di dalam controllernya
*/


Route::get('/', function () {
    return view('home',[
        "title" => "Home",
        'active' =>"home"

    ]);
});

//Mengirim data kedalam classs didalam controller post, dan menjalankan method
Route::get('/posts', [PostController::class, 'index']);


// Halaman Single post diakses sambil mengirim parameter slug
//dengan route  model binding, kita harus menuliskan data yang akan dikirim dengan spesifik
//misalnya kita hanya menulis 'post' saja, maka akan mengirim id sebagai data unik yang default
Route::get('/posts/{post:slug}', [PostController::class, 'show']);

//routes untuk All categories
Route::get('/categories', function(){
    return view('categories', [
        'title' => 'All Post Categories',
        "active" => "categories",
        'categories' => Category::all()
 ]);

});


Route::get('/about', function () {
    return view('about', [
        "title" => "About",
        "active" => "about",
        "nama" => "T.Imam Suranda",
        "email" => "imamsuranda@yahoo.com",
        "gambar" => "imam.jpg"

    ]);
});

// route dari navbar untuk masuk kehalaman login
// fitur login hanya boleh diakses oleh user yang belum login
// jadi, disini kita menggunkan middleware 'guest' (tamu)
// user akan redirect ke route name 'login', jika mencoba mengakses halaman authentikasi tanpa login
Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');

// route dari halaman login untuk authentikasi
Route::post('/login', [LoginController::class, 'authenticate']);

// route untuk logout
Route::post('/logout', [LoginController::class, 'logout']);

// route dari halaman login untuk masuk kehalaman register
// fitur register hanya boleh diakses oleh user yang belum login/register
// jadi, disini kita menggunkan middleware 'guest' (tamu)
Route::get('/register', [RegisterController::class, 'create'])->middleware('guest');

// route dari halaman register untuk melakukan registrasi
Route::post('/register', [RegisterController::class, 'store']);

// route untuk dashboard
// fitur dashboard hanya boleh diakses oleh user yang sudah login
// jadi, disini kita menggunkan middleware 'auth' (user yg sudah ter-authentikasi)
Route::get('/dashboard', function(){
    return view('dashboard.index');
})->middleware('auth');

//route untuk menangani request url slug
Route::get('/dashboard/post/checkSlug', [DashboardPostController::class, 'checkSlug']);

//Dashboard resource controller
Route::resource('/dashboard/posts', DashboardPostController::class)->middleware('auth');

//Admin Category resource controller
Route::resource('/dashboard/categories', AdminCategoryController::class)->except('show')->middleware('admin');