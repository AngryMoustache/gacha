<?php

use App\Enums\CurrencyType;
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
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('attachment_id')->constrained();
            $table->integer('pull_cost')->default(0);
            $table->string('needed_currency')->default(CurrencyType::GEMS->value);
            $table->string('needed_tickets')->default(CurrencyType::BANNER_TICKETS->value);
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->timestamps();
        });

        Schema::create('banner_hero', function (Blueprint $table) {
            $table->id();
            $table->foreignId('banner_id')->constrained()->cascadeOnDelete();
            $table->foreignId('hero_id')->constrained()->cascadeOnDelete();
        });

        Schema::create('banner_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('banner_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->integer('four_star_pity')->default(0);
            $table->integer('five_star_pity')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('banner_user');
        Schema::dropIfExists('banner_hero');
        Schema::dropIfExists('banners');
    }
};
