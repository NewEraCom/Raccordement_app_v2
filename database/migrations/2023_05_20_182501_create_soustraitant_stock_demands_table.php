<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSoustraitantStockDemandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('soustraitant_stock_demands', function (Blueprint $table) {
            $table->id();
            $table->foreignId('soustraitant_id')->nullable()->constrained('soustraitants')->onDelete('cascade')->onUpdate('cascade');            
            $table->integer('f680')->default(0);
            $table->integer('f6600')->default(0);
            $table->integer('pto')->default(0);
            $table->integer('jarretiere')->default(0);
            $table->integer('cable')->default(0);
            $table->integer('fix')->default(0);
            $table->integer('splitter')->default(0);
            $table->boolean('status')->default(0);
            $table->datetime('validation_date')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('validate_by')->nullable()->constrained('users')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('soustraitant_stock_demands');
    }
}
