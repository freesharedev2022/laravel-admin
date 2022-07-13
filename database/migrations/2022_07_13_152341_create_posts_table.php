<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->increments('id');
            $table->string('title', 255);
            $table->string("slug", 200)->nullable();
            $table->string('image', 512)->nullable();
            $table->string('description', 4000)->nullable();
            $table->text('content')->nullable();
            $table->integer('category_id')->unsigned()->nullable();
            $table->foreign("category_id")->references("id")->on("category")->onDelete("set null");
            $table->string("category_other", 200)->nullable();
            $table->string('keyword', 200)->nullable();
            $table->tinyInteger('status')->default(1)->comment("0 là đang chờ, 1 là xuất bản");
            $table->timestamps();
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
