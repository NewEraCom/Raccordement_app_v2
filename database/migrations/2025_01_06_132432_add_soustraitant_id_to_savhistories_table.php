<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSoustraitantIdToSavhistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('savhistories', function (Blueprint $table) {
            $table->unsignedBigInteger('soustraitant_id')->nullable()->after('id'); 
            $table->foreign('soustraitant_id')->references('id')->on('soustraitants')->onDelete('cascade'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('savhistories', function (Blueprint $table) {
            $table->dropForeign(['soustraitant_id']); 
            $table->dropColumn('soustraitant_id'); 
        });
    }
}
