<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableFeedbackSav extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feedback_sav', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->uniqid();
            $table->foreignId('sav_ticket_id')->nullable()->constrained('sav_tickets')->onDelete('cascade')->onUpdate('cascade');
            $table->string('root_cause');
            $table->integer('unite')->nullable();
            $table->string('type')->nullable();
            $table->string('before_picture')->nullable();
            $table->string('after_picture')->nullable();
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
        Schema::dropIfExists('feedback_sav');
    }
}
