<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
    //membuat object factory/faker untuk digunakan  pada database seeder

        return [

            'title' => $this->faker->sentence(mt_rand(2, 8)),
            'slug' => $this->faker->slug(),
            'excerpt' => $this->faker->paragraph(),

            //memetakan array collection
            //lalu gunakan method implode untuk menggabung paragraf dengan <p>
            'body' => collect($this->faker->paragraphs(mt_rand(5, 10)))
                   
                 // melakukan mapping dari data array collection (faker->paragraphs(mt_rand(5, 10))  
                  ->map(function($paragraph) { 
                    // dan mengembalikan nilai dengan menambahkan attribut <p> di awal dan di akhir
                    return "<p>$paragraph</P>";
                    })
                // lalu kemudian pisahkan tiap paragraf dengan spasi
                ->implode(''),

            'user_id'=> mt_rand(1, 3),
            'category_id' => mt_rand(1, 2)

        ];
    }
}
