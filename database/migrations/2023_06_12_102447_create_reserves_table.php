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
        Schema::create('reserves', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('manage_id')->comment('医院ID');
            $table->uuid('user_id')->comment('ユーザーID');
            $table->uuid('staff_id')->comment('スタッフID');
            $table->uuid('unit_id')->comment('ユニットID');
            $table->integer('patient_id')->nullable()->comment('患者テーブルID');
            $table->date('reserve_date')->comment('予約日');
            $table->time('start_time')->comment('予約開始時間');
            $table->time('end_time')->comment('予約終了時間');
            $table->string('patient_registration')->nullable()->default(null)->comment('診察番号');
            $table->dateTime('cancel_date')->nullable()->comment('予約キャンセル日時');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('manage_id')->references('id')->on('manages')->onDelete('cascade');
            $table->foreign('staff_id')->references('id')->on('staff')->onDelete('cascade');
            $table->foreign('unit_id')->references('id')->on('units')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reserves');
    }
};
