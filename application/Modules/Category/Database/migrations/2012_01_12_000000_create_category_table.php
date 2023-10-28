<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('name_fa')->nullable()->comment('persian');
            $table->string('description')->nullable();
            $table->string('description_fa')->nullable();
            $table->enum('status', \Modules\Category\Models\Category::STATUS)->default(\Modules\Category\Models\Category::STATUS_ACTIVE);
            $table->integer('priority')->default(0);
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->foreign('parent_id')->references('id')->on('category');
            $table->bigInteger('view')->default(0);
            $table->softDeletes();
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
        Schema::dropIfExists('category');
    }
}
