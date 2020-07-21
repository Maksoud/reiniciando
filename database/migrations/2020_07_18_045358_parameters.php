<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Parameters extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parameters', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('plans_id')->nullable();
            $table->string('title');
            $table->string('razao_social')->nullable();
            $table->string('ie')->nullable();
            $table->string('im')->nullable();
            $table->string('cpfcnpj')->nullable();
            $table->char('type', 1);
            $table->string('email');
            $table->string('address')->nullable();
            $table->string('neighborhood')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->integer('cep')->nullable();
            $table->string('phone1')->nullable();
            $table->string('phone2')->nullable();
            $table->string('logo')->nullable();
            $table->date('bill_date');

            $table->foreign('plans_id')->references('id')->on('plans');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('parameters');
    }
}
