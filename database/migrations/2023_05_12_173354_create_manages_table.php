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
        Schema::create('manages', function (Blueprint $table) {
            // $table->id();
            $table->uuid('id')->primary();
            $table->string('dental_name');
            $table->string('email')->unique();
            $table->string('tel')->comment('医院電話番号');
            $table->string('last_name')->comment('代表者姓');
            $table->string('first_name')->comment('代表者名');
            $table->string('last_name_kana')->comment('代表者姓(フリガナ)');
            $table->string('first_name_kana')->comment('代表者名(フリガナ)');
            $table->string('post_number')->comment('郵便番号');
            $table->integer('prefecture_number')->nullable()->comment('都道府県番号');
            $table->string('address1')->comment('都道府県');
            $table->string('address2')->comment('市町村区');
            $table->string('address3')->comment('町域');
            $table->string('address4')->comment('以降の住所');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
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
        Schema::dropIfExists('manages');
    }
};
