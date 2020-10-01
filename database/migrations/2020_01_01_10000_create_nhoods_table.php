<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNhoodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nhoods', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->unsignedBigInteger('city_id');
            $table->foreign('city_id')
                  ->references('id')->on('cities')
                  ->onDelete('cascade');
            $table->string('slug');
            $table->integer('product_count')->unsigned()->default(0);
            $table->bigInteger('longitude')->nullable();
            $table->bigInteger('latitude')->nullable();
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
        Schema::dropIfExists('nhoods');
    }
}
