<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MovementsMovementCards extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movements_movement_cards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parameters_id');
            $table->foreignId('movements_id');
            $table->foreignId('cards_id');
            $table->date('bill_date');
            
            $table->foreign('parameters_id')->references('id')->on('parameters')->onDelete('cascade');
            $table->foreign('movements_id')->references('id')->on('movements')->onDelete('cascade');
            $table->foreign('cards_id')->references('id')->on('cards')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('movements_movement_cards');
    }
}
