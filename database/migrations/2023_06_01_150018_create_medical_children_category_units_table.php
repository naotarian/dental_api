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
        Schema::create('medical_children_category_unit', function (Blueprint $table) {
            $table->id();
            $table->uuid('unit_id')->comment('ユニットID');
            $table->integer('medical_children_category_id');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('unit_id')->references('id')->on('units')->onDelete('cascade');
            $table->foreign('medical_children_category_id')->references('id')->on('medical_children_categories')->name('manage_category_id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('medical_children_category_unit');
    }
};
