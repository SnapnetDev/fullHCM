<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePerformanceSeasonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('performance_seasons', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('reviewFreq')->nullable();
            $table->string('reminderMessage')->nullable();
            $table->integer('reviewStart')->nullable();
            $table->integer('company_id')->nullable();
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
        Schema::dropIfExists('performance_seasons');
    }
}
