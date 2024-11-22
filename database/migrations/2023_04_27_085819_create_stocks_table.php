<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->integer('pto')->default(0);
            $table->integer('routeur')->default(0);
            $table->integer('cable_indoor')->default(0);
            $table->integer('cable_outdoor')->default(0);
            $table->integer('splitter')->default(0);
            $table->integer('jarretier')->default(0);
            $table->string('type_jarretier')->default(0);
            $table->integer('fix')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stocks');
    }
}
