<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIncomingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::enableForeignKeyConstraints();
        Schema::create('incomings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('spk_id');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('item_id');
            $table->string('no_seri')->unique();
            $table->string('tgl_masuk');
            $table->string('barcode');
            $table->boolean('status_out')->default(0);
            $table->string('author');

            $table->timestamps();

            $table->foreign('spk_id')->references('id')->on('spks')
                ->onDelete('cascade');

            $table->foreign('category_id')->references('id')->on('categories')
                ->onDelete('cascade');

            $table->foreign('item_id')->references('id')->on('items')
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
        Schema::dropIfExists('incomings');
    }
}
