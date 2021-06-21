<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJuniperMistFetchDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('juniper_mist_fetch_data', function (Blueprint $table) {
            $table->id();
            $table->integer('location_id');
            $table->string('mac_address');
            $table->string('connection_type');
            $table->timestamp('request_time')->isCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('juniper_mist_fetch_data');
    }
}
