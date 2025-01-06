<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableBlocagesSav extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blocages_sav', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->uniqid();
            $table->foreignId('sav_ticket_id')->nullable()->constrained('sav_tickets')->onDelete('cascade')->onUpdate('cascade');
            $table->string('cause',250);
            $table->string('justification',1000)->nullable();
            $table->string('lat')->nullable();
            $table->string('lng')->nullable();
            $table->tinyInteger('resolue');
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
        Schema::dropIfExists('blocages_sav');
    }
}
