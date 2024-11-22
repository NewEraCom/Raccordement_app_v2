<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeclarationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('declarations', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->foreignId('affectation_id')->constrained('affectations')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('routeur_id')->constrained('routeurs')->onDelete('cascade')->onUpdate('cascade');
            $table->string('test_signal');
            $table->binary('image_test_signal')->nullable();
            $table->binary('image_pbo_before')->nullable();
            $table->binary('image_pbo_after')->nullable();
            $table->binary('image_pbi_after')->nullable();
            $table->binary('image_pbi_before')->nullable();
            $table->binary('image_splitter')->nullable();
            $table->string('type_passage')->nullable();
            $table->binary('image_passage_1')->nullable();
            $table->binary('image_passage_2')->nullable();
            $table->binary('image_passage_3')->nullable();
            $table->string('sn_telephone')->nullable();
            $table->string('nbr_jarretieres')->nullable();
            $table->string('cable_metre')->nullable();
            $table->string('pto');
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
        Schema::dropIfExists('declarations');
    }
}
