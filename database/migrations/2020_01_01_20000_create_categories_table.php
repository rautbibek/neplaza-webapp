<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('image')->default('default.png');
            $table->string('slug');
            $table->string('icons')->default('fas fa-ban');
            $table->string('url');
            $table->boolean('visible')->default(true);
            $table->integer('view_count')->unsigned()->default(0);
            $table->integer('product_count')->unsigned()->default(0);
            $table->integer('display_order')->unsigned()->default(0);
            
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
        Schema::dropIfExists('categories');
    }
}
