<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDeviceSpecs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('firebase_keys', function (Blueprint $table) {
            $table->string('device_name', 255)->nullable();
            $table->string('device_uuid', 255)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('firebase_keys', function (Blueprint $table) {
            $table->dropColumn(['device_name']);
            $table->dropColumn(['device_uuid']);
        });
    }
}
