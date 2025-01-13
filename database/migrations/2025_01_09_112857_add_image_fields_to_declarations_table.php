<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddImageFieldsToDeclarationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('declarations', function (Blueprint $table) {
            $table->string('image_test_signal_url', 255)->nullable();
            $table->string('image_pbo_before_url', 255)->nullable();
            $table->string('image_pbo_after_url', 255)->nullable();
            $table->string('image_pbi_after_url', 255)->nullable();
            $table->string('image_pbi_before_url', 255)->nullable();
            $table->string('image_splitter_url', 255)->nullable();
            $table->string('image_passage_1_url', 255)->nullable();
            $table->string('image_passage_2_url', 255)->nullable();
            $table->string('image_passage_3_url', 255)->nullable();
            $table->string('image_cin_url', 255)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('declarations', function (Blueprint $table) {
            $table->dropColumn([
                'image_test_signal_url',
                'image_pbo_before_url',
                'image_pbo_after_url',
                'image_pbi_after_url',
                'image_pbi_before_url',
                'image_splitter_url',
                'image_passage_1_url',
                'image_passage_2_url',
                'image_passage_3_url',
                'image_cin_url',
            ]);
        });
    }
}
