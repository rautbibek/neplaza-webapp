<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductPropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_properties', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')
                  ->references('id')->on('products')
                  ->onDelete('cascade');
            $table->string('user_name');
            $table->string('category_name');
            $table->string('scategory_name');
            $table->string('city_name');
            $table->string('nhood_name');
            $table->string('brand_name')->nullable();
            $table->string('brand_model_name')->nullable();
            $table->string('type_name')->nullable();
            $table->string('status_name')->nullable();
            $table->string('filter_name')->nullable();
            $table->string('filter_1_name')->nullable();
            $table->string('filter_2_name')->nullable();
            $table->string('filter_3_name')->nullable();
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
        Schema::dropIfExists('product_properties');
    }
}
