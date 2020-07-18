<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Balances extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('balances', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('parameters_id');
            $table->foreignId('banks_id')->nullable();
            $table->foreignId('boxes_id')->nullable();
            $table->foreignId('cards_id')->nullable();
            $table->foreignId('plannings_id')->nullable();
            $table->date('date');
            $table->decimal('value', 10, 2);
            
            $table->foreign('parameters_id')->references('id')->on('parameters')->onDelete('cascade');
            $table->foreign('banks_id')->references('id')->on('banks')->onDelete('cascade');
            $table->foreign('boxes_id')->references('id')->on('boxes')->onDelete('cascade');
            $table->foreign('cards_id')->references('id')->on('cards')->onDelete('cascade');
            $table->foreign('plannings_id')->references('id')->on('plannings')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('balances');
    }
}
