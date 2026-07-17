<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAboutServiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('about_service', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('about_us_id')->default(1);
            $table->text('service');
            $table->timestamps();

            $table->foreign('about_us_id')->references('id')->on('about_us')->onUpdate('no action')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('about_service');
    }
}
