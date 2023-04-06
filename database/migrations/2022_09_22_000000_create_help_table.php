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
            $table->id()->index();
            $table->string('app_number')->nullable();
            $table->unsignedSmallInteger('category_id');
            $table->foreign('category_id')->references('id')->on('category')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedTinyInteger('status_id')->default(1);
            $table->foreign('status_id')->references('id')->on('status')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedTinyInteger('priority_id')->default(1);
            $table->foreign('priority_id')->references('id')->on('priority')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedSmallInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedSmallInteger('executor_id')->nullable();
            $table->foreign('executor_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->json('images')->nullable();
            $table->dateTime('calendar_request')->nullable();
            $table->dateTime('calendar_accept')->nullable();
            $table->dateTime('calendar_warning')->nullable();
            $table->dateTime('calendar_execution')->nullable();
            $table->dateTime('calendar_final')->nullable();
            $table->longText('description_long');
            $table->longText('info')->nullable();
            $table->longText('info_final')->nullable();
            $table->json('images_final')->nullable();
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
