<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEnvironmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('environments', function (Blueprint $table) {
            $table->string('id', 5);
            $table->string('name');
            $table->string('chapter_id', 5);

            $table->primary('id');
            $table->unique('name');

            $table->foreign('chapter_id')->references('id')->on('chapters');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('environments');
    }
}
