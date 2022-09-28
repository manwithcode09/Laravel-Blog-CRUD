<?php

namespace Database\Seeders;
use \App\Models\Category;
use \App\Models\Post;
use \App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */

    //memanggil seeder menggunakan factory
    public function run(){
        
    User::create([

        'name' => 'T.Imam Suranda',
        'username' => 'imamsuranda',
        'email' => 'imamsuranda@yahoo.com',
        'password' => bcrypt('imam')

    ]);


    //Generate user
    User::factory(3)->create();

    //Generate category
    Category::create([

        'name' => 'Web Programming',
        'slug' => 'web-programming'
    ]);

    Category::create([

        'name' => 'Web Design',
        'slug' => 'web-design'
    ]);


    Category::create([

        'name' => 'Networking',
        'slug' => 'networking'
    ]);
    
    //Generate post
    Post::factory(15)->create();
    
    }

}
