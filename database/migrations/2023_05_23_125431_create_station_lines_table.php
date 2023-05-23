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
        Schema::create('station_lines', function (Blueprint $table) {
            $table->id();
            $table->integer('line_code')->comment('路線コード');
            $table->integer('company_code')->comment('会社コード');
            $table->string('line_name')->comment('路線名');
            $table->string('line_name_kana')->comment('路線名カナ');
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
        Schema::dropIfExists('station_lines');
    }
};
