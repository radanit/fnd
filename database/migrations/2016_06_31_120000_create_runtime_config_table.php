<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Creates the runtime config database schema
 */
class CreateRuntimeConfigTable extends Migration
{
    /**
     * Runs the Migration
     *
     * @return void
     */
    public function up()
    {
        Schema::create('configs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('key')->unique();
            $table->longText('value');           
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverts the migrations
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('configs');
    }
}
