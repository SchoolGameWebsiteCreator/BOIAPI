<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlatformInstallmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('platform_installments', function (Blueprint $table) {
            $table->string('platform_id', 5);
            $table->string('installment_id', 5);

            $table->unique(['platform_id', 'installment_id']);

            $table->foreign('platform_id')->references('id')->on('platforms');
            $table->foreign('installment_id')->references('id')->on('installments');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('platform_installments');
    }
}
