<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('help', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('category_id')->unsigned();
            $table->foreign('category_id')->references('id')->on('category')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->integer('status_id')->unsigned()->default(2);
            $table->foreign('status_id')->references('id')->on('status')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->integer('cabinet_id')->unsigned();
            $table->foreign('cabinet_id')->references('id')->on('cabinet')
                ->onUpdate('cascade')->onDelete('cascade');
           $table->integer('priority_id')->unsigned();
           $table->foreign('priority_id')->references('id')->on('priority')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->integer('work_id')->unsigned();
            $table->foreign('work_id')->references('id')->on('work')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->integer('executor_id')->unsigned()->nullable();
            $table->foreign('executor_id')->references('id')->on('work')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->dateTime('calendar_request')->nullable();
            $table->dateTime('calendar_accept')->nullable();
            $table->dateTime('calendar_final')->nullable();
            $table->dateTime('calendar_warning')->nullable();
            $table->dateTime('calendar_execution')->nullable();
            $table->json('images')->nullable();
            $table->longText('description_long');
            $table->longText('info')->nullable();
            $table->longText('info_final')->nullable();
            $table->boolean('check_write')->default(false);
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
        Schema::dropIfExists('help');
    }
};
