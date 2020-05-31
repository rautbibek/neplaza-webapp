<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('productid')->unique();



            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')
                  ->references('id')->on('users')
                  ->onDelete('cascade');
            $table->unsignedBigInteger('city_id');
            $table->foreign('city_id')
                  ->references('id')->on('cities')
                  ->onDelete('cascade');

            $table->unsignedBigInteger('nhood_id');
            $table->foreign('nhood_id')
                  ->references('id')->on('nhoods')
                  ->onDelete('cascade');

            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')
                  ->references('id')->on('categories')
                  ->onDelete('cascade');

            $table->unsignedBigInteger('scategory_id');
            $table->foreign('scategory_id')
                  ->references('id')->on('scategories')
                  ->onDelete('cascade');

            $table->unsignedBigInteger('brand_id')->nullable();
            $table->foreign('brand_id')
                  ->references('id')->on('brands')
                  ->onDelete('cascade');

            $table->unsignedBigInteger('brand_model_id')->nullable();
            $table->foreign('brand_model_id')
                  ->references('id')->on('brand_models')
                  ->onDelete('cascade');

            $table->unsignedBigInteger('type_id')->nullable();
            $table->foreign('type_id')
                  ->references('id')->on('types')
                  ->onDelete('cascade');

            $table->unsignedBigInteger('status_id')->nullable();
            $table->foreign('status_id')
                  ->references('id')->on('statuses')
                  ->onDelete('cascade');

            $table->unsignedBigInteger('filter_id')->nullable();
            $table->foreign('filter_id')
                  ->references('id')->on('filters')
                  ->onDelete('cascade');

            $table->unsignedBigInteger('filter_1_id')->nullable();
            $table->foreign('filter_1_id')
                  ->references('id')->on('filter_1s')
                  ->onDelete('cascade');

            $table->unsignedBigInteger('filter_2_id')->nullable();
            $table->foreign('filter_2_id')
                  ->references('id')->on('filter_2s')
                  ->onDelete('cascade');

           $table->unsignedBigInteger('filter_3_id')->nullable();
           $table->foreign('filter_3_id')
                 ->references('id')->on('filter_3s')
                 ->onDelete('cascade');

            $table->string('property_1')->nullable();
            $table->string('property_2')->nullable();
            $table->string('property_3')->nullable();
            $table->string('property_4')->nullable();
            $table->string('title');
            $table->text('description');
            $table->bigInteger('price');
            $table->bigInteger('maxprice')->nullable();
            $table->string('address');
            $table->tinyInteger('sold')->default(0);
            $table->tinyInteger('premium')->default(0);
            $table->integer('view_count')->default(0);
            $table->string('join')->nullable();
            $table->string('slug');
            $table->boolean('delivery')->default(0);
            $table->boolean('deleted')->default(0);
            $table->boolean('emergency_sell')->default(0);
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
        Schema::dropIfExists('products');
    }
}
