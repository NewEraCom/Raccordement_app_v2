<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableBlocagesSavPictures extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blocages_sav_pictures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('blocage_sav_id')->nullable()->constrained('blocages_sav')->onDelete('cascade')->onUpdate('cascade');
            $table->string('description',800);
            $table->string('attachement');
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
        Schema::dropIfExists('blocages_sav_pictures');
    }
}
