<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePasswordPolicies extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('password_policies', function (Blueprint $table) {
            $table->increments('id');
            $table->int('min_length')->default(6);
            $table->int('max_length')->nullable();
            $table->int('upper_case')->default(0);
            $table->int('lower_case')->default(0);
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
        Schema::dropIfExists('password_policies');
    }
}
