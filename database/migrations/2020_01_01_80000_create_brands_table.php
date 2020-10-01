<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBrandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brands', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('scategory_id');
            $table->string('name');
            $table->foreign('scategory_id')
                  ->references('id')->on('scategories')
                  ->onDelete('cascade');
            $table->integer('view_count')->default(0);
            $table->integer('product_count')->unsigned()->default(0);
            $table->string('brand_logo')->nullable();
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
        Schema::dropIfExists('brands');
    }
}
