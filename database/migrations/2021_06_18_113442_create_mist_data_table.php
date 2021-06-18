<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMistDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mist_data', function (Blueprint $table) {
            $table->id();
            $table->integer('location_id');
            $table->string('timeframe');
            $table->integer('unconnected_clients')->nullable();
            $table->integer('connected_clients')->nullable();
            $table->integer('recurring_clients')->nullable();
            $table->integer('dwelltime')->nullable();
            $table->timestamp('local_time')->isCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mist_data');
    }
}
