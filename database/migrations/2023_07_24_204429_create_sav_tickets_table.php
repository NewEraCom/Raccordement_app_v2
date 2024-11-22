<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSavTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sav_tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('clients')->onDelete('cascade')->onUpdate('cascade');
            $table->string('id_case');
            $table->string('type');
            $table->foreignId('technicien_id')->nullable()->constrained('techniciens')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('soustraitant_id')->nullable()->constrained('soustraitants')->onDelete('cascade')->onUpdate('cascade');
            $table->text('description');
            $table->string('debit');
            $table->string('status')->default('Saisie');
            $table->string('service_activity')->nullable();
            $table->foreignId('affected_by')->nullable()->constrained('users')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('sav_tickets');
    }
}
