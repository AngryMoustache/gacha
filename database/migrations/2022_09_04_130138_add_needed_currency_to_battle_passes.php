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
        Schema::table('battle_passes', function (Blueprint $table) {
            $table->after('attachment_id', function (Blueprint $table) {
                $table->string('needed_currency')->default(CurrencyType::BATTLE_PASS->value);
                $table->integer('levels_amount');
                $table->integer('per_level_requirement');
            });
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('battle_passes', function (Blueprint $table) {
            $table->dropColumn([
                'needed_currency',
                'levels_amount',
                'per_level_requirement',
            ]);
        });
    }
};
