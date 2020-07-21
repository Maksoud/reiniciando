<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Transfers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transfers', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('parameters_id');
            $table->foreignId('banks_id')->nullable();
            $table->foreignId('boxes_id')->nullable();
            $table->foreignId('costs_id')->nullable();
            $table->foreignId('event_types_id')->nullable();
            $table->foreignId('document_types_id')->nullable();
            $table->foreignId('account_plans_id')->nullable();
            $table->foreignId('banks_dest')->nullable();
            $table->foreignId('boxes_dest')->nullable();
            $table->foreignId('costs_dest')->nullable();
            $table->foreignId('account_plans_dest')->nullable();
            $table->integer('order_number');
            $table->string('document_number')->nullable();
            $table->string('title');
            $table->char('radio_source', 1);
            $table->char('radio_destination', 1);
            $table->date('date_consolidation');
            $table->decimal('value_consolidation', 10, 2);
            $table->boolean('contabil');
            $table->text('obs')->nullable();
            $table->string('username');
            $table->char('status', 1);
            
            $table->foreign('parameters_id')->references('id')->on('parameters')->onDelete('cascade');
            $table->foreign('banks_id')->references('id')->on('banks')->onDelete('cascade');
            $table->foreign('boxes_id')->references('id')->on('boxes')->onDelete('cascade');
            $table->foreign('costs_id')->references('id')->on('costs');
            $table->foreign('event_types_id')->references('id')->on('event_types');
            $table->foreign('document_types_id')->references('id')->on('document_types');
            $table->foreign('account_plans_id')->references('id')->on('account_plans');
            $table->foreign('banks_dest')->references('id')->on('banks')->onDelete('cascade');
            $table->foreign('boxes_dest')->references('id')->on('boxes')->onDelete('cascade');
            $table->foreign('costs_dest')->references('id')->on('costs');
            $table->foreign('account_plans_dest')->references('id')->on('account_plans');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transfers');
    }
}
