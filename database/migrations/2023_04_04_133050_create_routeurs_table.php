<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRouteursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('routeurs', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->string('sn_gpon');
            $table->string('sn_mac');
            $table->integer('status')->default(0);
            $table->foreignId('client_id')->nullable()->constrained('clients')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('technicien_id')->nullable()->constrained('techniciens')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('routeurs');
    }
}
