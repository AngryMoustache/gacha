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
        Schema::create('battle_passes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->foreignId('attachment_id')->nullable()->constrained()->nullOnDelete();
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->timestamps();
        });

        Schema::create('battle_pass_reward', function (Blueprint $table) {
            $table->id();
            $table->foreignId('battle_pass_id')->constrained()->cascadeOnDelete();
            $table->morphs('reward');
            $table->integer('amount');
            $table->integer('level_req');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('battle_pass_reward');
        Schema::dropIfExists('battle_passes');
    }
};
