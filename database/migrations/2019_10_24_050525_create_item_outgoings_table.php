<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemOutgoingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_outgoings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('item_id');
            $table->unsignedBigInteger('outgoing_id');
            $table->unsignedBigInteger('incoming_item_id');
            $table->unsignedBigInteger('location_id');

            $table->foreign('item_id')->references('id')->on('items')
                ->onDelete('cascade');

            $table->foreign('outgoing_id')->references('id')->on('outgoings')
                ->onDelete('cascade');

            $table->foreign('incoming_item_id')->references('id')->on('incoming_items')
                ->onDelete('cascade');

            $table->foreign('location_id')->references('id')->on('locations')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('item_outgoings');
    }
}
