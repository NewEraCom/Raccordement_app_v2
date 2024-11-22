<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlocagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blocages', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->uniqid();
            $table->foreignId('affectation_id')->nullable()->constrained('affectations')->onDelete('cascade')->onUpdate('cascade');
            $table->string('cause',250);
            $table->string('justification',1000)->nullable();
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
        Schema::dropIfExists('blocages');
    }
}
