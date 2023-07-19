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
            $table->string('app_number')->nullable()->index();
            $table->unsignedSmallInteger('category_id');
            $table->foreign('category_id')
                ->references('id')
                ->on('category')
                ->onDelete('cascade');
            $table->unsignedTinyInteger('status_id');
            $table->foreign('status_id')
                ->references('id')
                ->on('status')
                ->onDelete('cascade');
            $table->unsignedTinyInteger('priority_id')->default(1);
            $table->foreign('priority_id')
                ->references('id')
                ->on('priority')
                ->onDelete('cascade');
            $table->unsignedSmallInteger('user_id');
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->unsignedSmallInteger('executor_id')->nullable();
            $table->foreign('executor_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->json('images')->nullable();
            $table->json('images_final')->nullable();
            $table->longText('info')->nullable();
            $table->longText('info_final')->nullable();
            $table->dateTime('calendar_request')->nullable();
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
