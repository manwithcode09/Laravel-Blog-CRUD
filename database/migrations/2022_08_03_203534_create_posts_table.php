<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

//skema table untuk Post
class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id');
            $table->foreignId('user_id');
            $table->string('title');
            $table->string('slug')->unique(); //url-uniqe
            $table->string('image')->nullable(); //untuk menyimpan strin nama gambar 
            $table->text('excerpt'); //untuk menyimpan text read more
            $table->text('body'); //untuk menyimpan text lengkapnya
            $table->timestamp('published_at')->nullable(); //untuk keterangan kapan postingan di publish
            $table->timestamps(); //untuk keterangan kapan postingan dibuat(bisa jadi masih dalam bentuk draft)
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
