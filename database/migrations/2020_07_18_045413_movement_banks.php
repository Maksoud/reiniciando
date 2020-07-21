<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MovementBanks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movement_banks', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('parameters_id');
            $table->foreignId('banks_id')->nullable();
            $table->foreignId('costs_id')->nullable();
            $table->foreignId('event_types_id')->nullable();
            $table->foreignId('document_types_id')->nullable();
            $table->foreignId('providers_id')->nullable();
            $table->foreignId('customers_id')->nullable();
            $table->foreignId('account_plans_id')->nullable();
            $table->foreignId('transfers_id')->nullable();
            $table->foreignId('movements_id')->nullable();
            $table->foreignId('movement_checks_id')->nullable();
            $table->integer('order_number');
            $table->string('document_number')->nullable();
            $table->string('title');
            $table->char('recipeexpense', 1);
            $table->date('date');
            $table->date('bill_date');
            $table->decimal('value', 10, 2);
            $table->date('date_consolidation')->nullable();
            $table->decimal('value_consolidation', 10, 2)->nullable();
            $table->string('user_consolidation')->nullable();
            $table->boolean('contabil');
            $table->text('obs')->nullable();
            $table->string('username');
            $table->char('status', 1);
            
            $table->foreign('parameters_id')->references('id')->on('parameters')->onDelete('cascade');
            $table->foreign('banks_id')->references('id')->on('banks')->onDelete('cascade');
            $table->foreign('costs_id')->references('id')->on('costs');
            $table->foreign('event_types_id')->references('id')->on('event_types');
            $table->foreign('document_types_id')->references('id')->on('document_types');
            $table->foreign('providers_id')->references('id')->on('providers')->onDelete('cascade');
            $table->foreign('customers_id')->references('id')->on('customers')->onDelete('cascade');
            $table->foreign('account_plans_id')->references('id')->on('account_plans');
            $table->foreign('transfers_id')->references('id')->on('transfers')->onDelete('cascade');
            $table->foreign('movements_id')->references('id')->on('movements')->onDelete('cascade');
            $table->foreign('movement_checks_id')->references('id')->on('movement_checks')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('movement_banks');
    }
}
