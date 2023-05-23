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
        Schema::create('manage_medical_children_category', function (Blueprint $table) {
            $table->id();
            $table->uuid('manage_id')->comment('医院ID');
            $table->integer('medical_children_category_id');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('manage_id')->references('id')->on('manages')->onDelete('cascade');
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
        Schema::dropIfExists('manage_medical_children_category');
    }
};
