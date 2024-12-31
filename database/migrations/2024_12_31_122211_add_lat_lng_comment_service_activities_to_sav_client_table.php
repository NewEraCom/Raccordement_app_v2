<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLatLngCommentServiceActivitiesToSavClientTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sav_client', function (Blueprint $table) {
            $table->string('lat')->nullable()->after('plaque_id');
            $table->string('lng')->nullable()->after('lat');
            $table->text('comment')->nullable()->after('address');
            $table->string('service_activities')->nullable()->after('comment');
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
            $table->dropColumn(['lat', 'lng', 'comment', 'service_activities']);
        });
    }
}
    