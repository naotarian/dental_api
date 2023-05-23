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
        Schema::create('selected_stations', function (Blueprint $table) {
            $table->id();
            $table->uuid('manage_id')->comment('医院ID');
            $table->integer('company_code')->nullable()->comment('会社コード');
            $table->integer('line_code')->nullable()->comment('路線コード');
            $table->integer('station_code')->nullable()->comment('駅コード');
            $table->integer('station_group_code')->nullable()->comment('駅グループコード');
            $table->text('remark', 3000)->nullable()->comment('駅情報備考');
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
        Schema::dropIfExists('selected_stations');
    }
};
