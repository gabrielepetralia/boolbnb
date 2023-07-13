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
    Schema::create('apartment_sponsorship', function (Blueprint $table) {
      $table->unsignedBigInteger('apartment_id');
      $table->foreign('apartment_id')
        ->references('id')
        ->on('apartmets')
        ->cascadeOnDelete();


      $table->unsignedBigInteger('sponsorship_id');
      $table->foreign('sponsorship_id')
        ->references('id')
        ->on('sponsorships')
        ->cascadeOnDelete();

      $table->time('start_date');
      $table->time('finish_date');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('apartament_sponsorship');
  }
};
