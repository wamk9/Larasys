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
        Schema::create('stock_has_material_distributions', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->bigInteger('equipment_id')->unsigned();
            $table->bigInteger('stock_id')->unsigned();
            $table->integer('percent_profit')->unsigned();
            $table->float('price_reference', 10, 2, true);

            $table->foreign('equipment_id')->references('id')->on('equipmnts');
            $table->foreign('stock_id')->references('id')->on('stocks');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_has_material_distributions');
    }
};
