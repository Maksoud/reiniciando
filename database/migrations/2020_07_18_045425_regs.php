<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Regs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('regs', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('parameters_id');
            $table->foreignId('users_id');
            $table->string('log_type');
            $table->string('function');
            $table->string('content');
            $table->string('username');
            
            $table->foreign('parameters_id')->references('id')->on('parameters')->onDelete('cascade');
            $table->foreign('users_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('regs');
    }
}
