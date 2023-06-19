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
        Schema::create('day_of_weeks', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('曜日');
            $table->string('alphabet')->comment('アルファベット表記');
            $table->string('number')->comment('曜日番号');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('day_of_weeks');
    }
};
