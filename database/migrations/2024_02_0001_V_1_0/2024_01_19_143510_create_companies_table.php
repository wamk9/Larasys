<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->float('kilowatts_hour', 5, 3, true);
            $table->float('operational_cost', 5, 2, true);
            $table->tinyInteger('free_shipping_percentage', false, true);
            $table->float('free_shipping_min_cost_value', 5, 2, true);
            $table->float('free_shipping_extra_value', 4, 2, true);
            $table->tinyInteger('marketplace_cost_percentage', false, true);
            $table->float('marketplace_min_cost_value', 4, 2, true);
            $table->float('marketplace_extra_cost_value', 4, 2, true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
