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
      Schema::create('apartments', function (Blueprint $table) {
        $table->id();

        $table->string("title", 50);
        $table->string("slug", 50)->unique();
        $table->tinyInteger("num_rooms")->unsigned()->nullable();
        $table->tinyInteger("num_beds")->unsigned()->nullable();
        $table->tinyInteger("num_bathrooms")->unsigned()->nullable();
        $table->integer("square_meters")->unsigned()->nullable();
        $table->point("coordinates")->nullable();
        $table->string("address", 100)->nullable();
        $table->text("description")->nullable();
        $table->text("img_path")->nullable();
        $table->boolean("visible")->default(1);
        $table->decimal("price", 6, 2)->unsigned()->nullable();

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
        Schema::dropIfExists('apartments');
    }
};
