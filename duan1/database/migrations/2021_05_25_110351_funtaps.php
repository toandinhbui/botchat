<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class funtaps extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('funtaps', function (Blueprint $table) {
        $table->bigIncrements('id');
        $table->string('image_url')->nullable();
        $table->string('content')->nullable();
        $table->string('subtitle')->nullable();
        $table->string('title_element')->nullable();
        $table->integer('id_token')->nullable();
        $table->timestamps();
        $table->softDeletes();
    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('funtaps');
    }
}
