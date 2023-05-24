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
        Schema::create('staff', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('manage_id')->comment('所属医院ID');
            $table->string('last_name')->comment('姓');
            $table->string('first_name')->comment('名');
            $table->string('last_name_kana')->comment('姓(カナ)');
            $table->string('first_name_kana')->comment('名(カナ)');
            $table->string('nick_name')->comment('ニックネーム');
            $table->integer('gender')->comment('性別 1: 女性,2: 男性');
            $table->integer('color_id')->comment('スタッフカラーID');
            $table->integer('display_order')->comment('表示順');
            $table->integer('priority')->comment('予約優先順位');
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
        Schema::dropIfExists('staff');
    }
};
