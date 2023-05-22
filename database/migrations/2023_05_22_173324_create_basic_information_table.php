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
        Schema::create('basic_information', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('manage_id')->comment('医院ID');
            $table->time('business_start')->nullable()->comment('診療開始時間');
            $table->time('business_end')->nullable()->comment('診療終了時間');
            $table->json('closed')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('manage_id')->references('id')->on('manages')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('basic_information');
    }
};
