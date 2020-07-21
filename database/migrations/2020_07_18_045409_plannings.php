<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Plannings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plannings', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('parameters_id');
            $table->foreignId('costs_id')->nullable();
            $table->foreignId('providers_id')->nullable();
            $table->foreignId('customers_id')->nullable();
            $table->foreignId('account_plans_id')->nullable();
            $table->integer('order_number');
            $table->string('document_number')->nullable();
            $table->char('recipeexpense', 1);
            $table->date('date');
            $table->date('bill_date');
            $table->string('title');
            $table->decimal('value', 10, 2);
            $table->integer('parcels');
            $table->text('obs')->nullable();
            $table->string('username');
            $table->char('status', 1);
            
            $table->foreign('parameters_id')->references('id')->on('parameters')->onDelete('cascade');
            $table->foreign('costs_id')->references('id')->on('costs');
            $table->foreign('providers_id')->references('id')->on('providers')->onDelete('cascade');
            $table->foreign('customers_id')->references('id')->on('customers')->onDelete('cascade');
            $table->foreign('account_plans_id')->references('id')->on('account_plans');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plannings');
    }
}
