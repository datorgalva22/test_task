<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGuidesTable extends Migration
{
    
    public function up() {
        
        Schema::create('channels', function (Blueprint $table) {
            $table->bigIncrements('id')->index();
            $table->string('title');
        });
        
         
        Schema::create('guides', function (Blueprint $table) {
            $table->bigIncrements('id')->index();
            $table->unsignedBigInteger('channel_id')->nullable();
            $table->string('guid')->nullable();
            $table->string('title')->nullable();
            $table->string('time_str')->nullable();
            $table->smallInteger('time')->nullable();
            $table->integer('starts')->nullable();
            $table->integer('ends')->nullable();
            $table->smallInteger('duration')->nullable();
            $table->string('logo')->nullable();
            
            $table->foreign('channel_id')->references('id')->on('channels');
        });
    }

    public function down()
    {
        Schema::dropIfExists('channels');
        Schema::dropIfExists('guides');
    }
}
