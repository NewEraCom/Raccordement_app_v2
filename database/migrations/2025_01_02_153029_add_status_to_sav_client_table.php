<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusToSavClientTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */ 
    public function up()
    {
        Schema::table('sav_client', function (Blueprint $table) {
            $table->enum('status', ['Saisie', 'En cours', 'Planifié', 'Bloqué','Validé','Affecté'])->nullable()->after('contact');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sav_client', function (Blueprint $table) {
            //
        });
    }
}
