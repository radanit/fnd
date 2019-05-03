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
            $table->string('national_id')->comment('FK: users of type patient');
            $table->string('first_name')->comment('patient firstname');
            $table->string('last_name')->comment('patient lastname');
            $table->string('mobile',11);
            $table->string('birth_year',4);
            $table->boolean('gender');
            $table->unsignedInteger('doctor_id')->comment('FK: users of type doctor');
            $table->unsignedInteger('radio_type_id')->comment('FK: radio_types');
            $table->datetime('reception_date')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->tinyInteger('votes')->default(0);
            $table->timestamps();
            $table->softDeletes();
            $table->index('national_id');
            
            // Patient Relation
            $table->foreign('national_id')
                ->references('username')->on('users')
                ->onDelete('restrict')->onUpdate('cascade');

            // Doctor Relation
            $table->foreign('doctor_id')
            ->references('id')->on('users')
            ->onDelete('restrict')->onUpdate('cascade');

        });

        Schema::create('reception_status', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('reception_id')->comment('FK: receptions');
            $table->unsignedInteger('created_by')->comment('FK: users');
            $table->enum('status',['recepted','captured','visited','completed','rejected'])->default('recepted');
            $table->timestamps();            
        });

        Schema::create('reception_results', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('reception_id')->comment('FK: receptions');
            $table->unsignedInteger('created_by')->comment('FK: users');
            $table->text('result')->nullable();
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
        Schema::dropIfExists('reception_results');
        
    }
}
