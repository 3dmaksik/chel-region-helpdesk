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
            $table->string('app_number')->nullable()->index()->unique();
            $table->smallInteger('category_id')->default(1);
            $table->tinyInteger('status_id')->default(1);
            $table->tinyInteger('priority_id')->default(1);
            $table->smallInteger('user_id');
            $table->smallInteger('executor_id')->nullable();
            $table->json('images')->nullable();
            $table->json('images_final')->nullable();
            $table->longText('info')->nullable();
            $table->longText('info_final')->nullable();
            $table->dateTime('calendar_request');
            $table->dateTime('calendar_accept')->nullable();
            $table->dateTime('calendar_warning')->nullable();
            $table->dateTime('calendar_execution')->nullable();
            $table->dateTime('calendar_final')->nullable();
            $table->bigInteger('lead_at')->nullable();
            $table->longText('description_long');
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
