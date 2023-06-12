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
        Schema::create('reserve_details', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('reserve_id')->comment('予約ID');
            $table->integer('color_id')->comment('管理カラーID');
            $table->bigInteger('category_id')->unsigned();
            $table->string('last_name')->comment('姓');
            $table->string('first_name')->comment('名');
            $table->string('full_name')->comment('フルネーム');
            $table->string('last_name_kana')->comment('姓(フリガナ)');
            $table->string('first_name_kana')->comment('名(フリガナ)');
            $table->string('full_name_kana')->comment('フルネーム(フリガナ)');
            $table->integer('gender')->comment('性別');
            $table->string('mobile_tel')->nullable()->comment('携帯電話番号');
            $table->string('fixed_tel')->nullable()->comment('固定電話番号');
            $table->string('email')->nullable()->comment('メールアドレス');
            $table->string('birth')->nullable()->comment('生年月日');
            $table->string('examination')->nullable()->comment('当院での受診');
            $table->string('remark')->nullable()->comment('備考');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('reserve_id')->references('id')->on('reserves')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('medical_children_categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reserve_details');
    }
};
