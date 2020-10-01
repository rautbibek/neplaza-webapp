<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('role_id')->default(3);
            $table->foreign('role_id')
                  ->references('id')->on('roles')
                  ->onDelete('cascade');
            $table->string('name');
            $table->string('phone')->nullable();
            $table->integer('hide_contact')->default(0)->comment('0 for visible 1 for hidden');
            $table->string('username');
            $table->string('email')->unique();
            $table->unsignedBigInteger('city_id')->nullable();
            $table->unsignedBigInteger('nhood_id')->nullable();
            $table->foreign('city_id')
                ->references('id')->on('cities');

            $table->foreign('nhood_id')
               ->references('id')->on('nhoods');
            $table->boolean('account_status')->default(true)->comment('1 for active and 0 for deactive');
            $table->boolean('block_by_admin')->default(false)->comment('0 for active 1 for blocked');
            $table->string('login_privider')->nullable()->comment('socialite login provider');
            $table->string('provider_id')->nullable()->comment('socialite login provider id');
            $table->string('image')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->rememberToken();
            $table->text('about')->nullable();
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
        Schema::dropIfExists('users');
    }
}
