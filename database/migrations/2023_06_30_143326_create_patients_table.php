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
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->uuid('manage_id')->comment('医院ID');
            $table->string('patient_number')->nullable()->comment('診察券No');
            $table->string('last_name')->nullable()->comment('患者姓');
            $table->string('first_name')->nullable()->comment('患者名');
            $table->string('last_name_kana')->comment('患者姓(カナ)');
            $table->string('first_name_kana')->nullable()->comment('患者名(カナ)');
            $table->integer('gender')->nullable()->comment('患者性別');
            $table->string('mobile_tel')->nullable()->comment('携帯電話番号');
            $table->string('fixed_tel')->nullable()->comment('固定電話番号');
            $table->string('email')->nullable()->comment('メールアドレス');
            $table->string('birth')->nullable()->comment('生年月日');
            $table->text('remark')->nullable()->comment('患者備考');
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
        Schema::dropIfExists('patients');
    }
};
