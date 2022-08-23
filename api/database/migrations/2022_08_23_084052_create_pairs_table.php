<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pairs', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->float('rate',8 ,2);
            $table->unsignedBigInteger('currency_from_id')->nullable();
            $table->unsignedBigInteger('currency_to_id')->nullable();

            $table->foreign('currency_from_id')->nullable()->references('id')->on('currencies')->onDelete('cascade');


            $table->foreign('currency_to_id')->nullable()->references('id')->on('currencies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pairs');
    }
};
