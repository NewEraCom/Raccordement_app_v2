<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSavhistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('savhistories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('savticket_id')->constrained('sav_tickets')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('technicien_id')->nullable()->constrained('techniciens')->onDelete('cascade')->onUpdate('cascade');
            $table->string('status');
            $table->string('description')->nullable();
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
        Schema::dropIfExists('savhistories');
    }
}
