<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class OfferPost extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offer_post', function (Blueprint $table) {
            $table->increments('id');
            $table->string('currency');
            $table->integer('offer_rate');
            $table->string('offer_details');
            $table->integer('user_id');
            $table->string('user_name');
            $table->string('user_profile');
            $table->rememberToken();
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
        //
         Schema::dropIfExists('offer_post');
    }
}
