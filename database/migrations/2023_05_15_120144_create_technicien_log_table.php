<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTechnicienLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('technicien_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('technicien_id')->constrained('techniciens')->onDelete('cascade')->onUpdate('cascade');
            $table->string('lat');
            $table->string('lng');
            $table->integer('nb_affectation')->default(0);
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
        Schema::dropIfExists('technicien_logs');
    }
}
