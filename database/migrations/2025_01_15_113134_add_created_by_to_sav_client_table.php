<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCreatedByToSavClientTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sav_client', function (Blueprint $table) {
       
                $table->unsignedBigInteger('created_by')->nullable()->after('lng'); // Add the column after the 'id' column
                $table->foreign('created_by')->references('id')->on('users')->onDelete('set null'); // Set null on delete
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sav_client', function (Blueprint $table) {
            $table->dropForeign(['created_by']); // Drop the foreign key constraint
            $table->dropColumn('created_by'); // Drop the column
        });
    }
}
