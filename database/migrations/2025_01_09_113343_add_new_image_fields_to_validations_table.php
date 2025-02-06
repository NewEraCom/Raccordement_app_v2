<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewImageFieldsToValidationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('validations', function (Blueprint $table) {
            $table->string('test_debit_via_cable_image_url', 255)->nullable();
            $table->string('photo_test_debit_via_wifi_image_url', 255)->nullable();
            $table->string('etiquetage_image_url', 255)->nullable();
            $table->string('fiche_installation_image_url', 255)->nullable();
            $table->string('router_tel_image_url', 255)->nullable();
            $table->string('pv_image_url', 255)->nullable();
            $table->string('image_cin_url', 255)->nullable();
 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('validations', function (Blueprint $table) {
            $table->dropColumn([
                'test_debit_via_cable_image_url',
                'photo_test_debit_via_wifi_image_url',
                'etiquetage_image_url',
                'fiche_installation_image_url',
                'router_tel_image_url',
                'pv_image_url',
                'image_cin_url',
                'test_debit_via_cable',
                'test_debit_via_wifi',
            ]);
        });
    }
}
