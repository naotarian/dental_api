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
        Schema::create('units', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('manage_id')->comment('医院ID');
            $table->string('name')->comment('ユニット名');
            $table->string('display_name')->comment('表示名');
            $table->integer('display_order')->comment('表示順');
            $table->integer('priority')->comment('予約優先順位');
            $table->string('status')->comment('S:稼働中, M:稼働停止中');
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
        Schema::dropIfExists('units');
    }
};
