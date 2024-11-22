<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateValidationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('validations', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->foreignId('affectation_id')->constrained('affectations')->onDelete('cascade')->onUpdate('cascade');
            $table->binary('test_debit_image')->nullable();
            $table->binary('test_debit_via_cable_image')->nullable();
            $table->binary('photo_test_debit_via_wifi_image')->nullable();
            $table->binary('etiquetage_image')->nullable();
            $table->binary('fiche_installation_image')->nullable();
            $table->binary('router_tel_image')->nullable();
            $table->binary('pv_image')->nullable();
            $table->string('lat')->nullable();
            $table->string('lng')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('validations');
    }
}
