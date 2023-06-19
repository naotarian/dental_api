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
        Schema::create('day_of_week_manage', function (Blueprint $table) {
            $table->id();
            $table->uuid('manage_id')->comment('医院ID');
            $table->bigInteger('day_of_week_id')->unsigned();
            $table->timestamps();
            $table->foreign('day_of_week_id')->references('id')->on('day_of_weeks')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('day_of_week_manage');
    }
};
