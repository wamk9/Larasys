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
        Schema::create('material_distributions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('material_id', false, true);
            $table->bigInteger('company_id', false, true);
            $table->string('reference_code');
            $table->float('quantity_bought', 10, 1, true);
            $table->float('quantity_used', 10, 1, true);
            $table->float('price', 10, 2, true);
            $table->date('bought_at');
            $table->longText('description');
            $table->timestamps();

            $table->foreign('company_id')->references('company_id')->on('materials');
            $table->foreign('material_id')->references('id')->on('materials');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('material_distributions');
    }
};
