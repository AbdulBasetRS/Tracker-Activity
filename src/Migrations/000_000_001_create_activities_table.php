<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(config('tracker-activity.table_name'), function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['event', 'exception','route','info'])->default('info');
            $table->string('subject');
            $table->integer('auth_id')->nullable();
            $table->string('class_name')->nullable();
            $table->string('ip')->nullable();
            $table->text('user_agent')->nullable();
            $table->json('query_parameters')->nullable();
            $table->string('request_method')->nullable();
            $table->json('headers')->nullable();
            $table->text('referring_url')->nullable();
            $table->text('current_url')->nullable();
            $table->text('description')->nullable();
            $table->json('properties')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists(config('tracker-activity.table_name'));
    }
};
