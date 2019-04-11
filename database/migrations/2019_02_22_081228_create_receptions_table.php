<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReceptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receptions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('patient_id')->comment('FK: users');
            $table->unsignedInteger('radio_type_id')->comment('FK: radio_types');           
            $table->datetime('reception_date')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->tinyInteger('votes')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('reception_status', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('reception_id')->comment('FK: receptions');
            $table->unsignedInteger('created_by')->comment('FK: users');
            $table->enum('status',['recepting','recepted','confirmed','rejected'])->default('recepting');
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
        Schema::dropIfExists('receptions');
        Schema::dropIfExists('reception_status');
        
    }
}
