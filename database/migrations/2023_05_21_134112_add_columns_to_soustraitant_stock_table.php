<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToSoustraitantStockTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('soustraitant_stocks', function (Blueprint $table) {
            $table->integer('splitter')->default(0);
            $table->integer('racco')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('soustraitant_stocks', function (Blueprint $table) {
            //
        });
    }
}
