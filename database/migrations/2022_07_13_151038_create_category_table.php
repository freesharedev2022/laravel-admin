<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category', function (Blueprint $table) {
            $table->increments("id");
            $table->string("name", 200);
            $table->string("slug", 200)->nullable();
            $table->integer("parent_id")->unsigned()->nullable();
            $table->foreign("parent_id")->references("id")->on("category")->onDelete("set null");
            $table->string("type")->default("cate"); // cate or tag
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
        Schema::dropIfExists('category');
    }
}
