<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSoustraitantIdToAffectationHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('affectation_histories', function (Blueprint $table) {
            $table->unsignedBigInteger('soustraitant_id')->nullable()->after('technicien_id');
            $table->foreign('soustraitant_id')->references('id')->on('soustraitants')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('affectation_histories', function (Blueprint $table) {
            $table->dropForeign(['soustraitant_id']);
            $table->dropColumn('soustraitant_id');
        });
    }
}
