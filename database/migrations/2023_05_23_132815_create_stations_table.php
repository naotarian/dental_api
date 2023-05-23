<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stations', function (Blueprint $table) {
            $table->id();
            $table->integer('station_code')->comment('駅コード(同じ駅でも別路線だとコード)');
            $table->integer('station_group_code')->comment('駅コード(別路線でも同じコード)');
            $table->string('station_name')->comment('駅名');
            $table->integer('line_code')->comment('路線コード');
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
        Schema::dropIfExists('stations');
    }
};
