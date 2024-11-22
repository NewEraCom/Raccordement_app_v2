<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlaqueSoustraitantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plaque_soustraitants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('plaque_id')->constrained('plaques')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('soustraitant_id')->constrained('soustraitants')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('plaque_soustraitants');
    }
}
