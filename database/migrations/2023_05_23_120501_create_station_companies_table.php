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
        Schema::create('station_companies', function (Blueprint $table) {
            $table->id();
            $table->integer('company_code')->comment('会社コード');
            $table->string('company_name')->comment('会社名');
            $table->string('company_name_kana')->comment('会社名カナ');
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
        Schema::dropIfExists('station_companies');
    }
};
