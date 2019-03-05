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
            $table->string('name')->unique();
            $table->string('description')->nullable();
            $table->integer('min_length')->default(6);
            $table->integer('max_length')->nullable()->default(NULL);
            $table->integer('upper_case')->default(0);
            $table->integer('lower_case')->default(0);
            $table->integer('digits')->default(6);
            $table->integer('special_chars')->default(0);
            $table->string('does_not_contain')->nullable()->default(NULL);
            $table->timestamps();
        });

        // Add field for relation
        /*
        Schema::table('profiles', function($table) {
             $table                
                ->unsignedInteger('password_policy_id')
                ->after('structure')
                ->comment('Add by Radan PasswordPolicy package')                
                ->default(1);
        });*/

         
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('password_policies');

        // Drop field for relation
        Schema::table('profiles', function($table) {
            $table->dropColumn('password_policy_id');
        });
    }
}
