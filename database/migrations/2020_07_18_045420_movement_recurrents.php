<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MovementRecurrents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movement_recurrents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parameters_id');
            $table->foreignId('movements_id');
            $table->foreignId('movement_cards_id');
            
            $table->foreign('parameters_id')->references('id')->on('parameters')->onDelete('cascade');
            $table->foreign('movements_id')->references('id')->on('movements')->onDelete('cascade');
            $table->foreign('movement_cards_id')->references('id')->on('movement_cards')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('movement_recurrents');
    }
}
