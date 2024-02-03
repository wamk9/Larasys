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
        Schema::create('equipments', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('company_id', false, true);
            $table->string('name');
            $table->string('reference_code')->unique();
            $table->float('price', 10, 2, true);
            $table->date('bought_at');
            $table->tinyInteger('depreciation', false, true);
            $table->date('max_date_return_value');
            $table->float('return_value', 10, 2, true);
            $table->float('use_value', 10, 2, true);
            $table->integer('watts_consume', false, true);
            $table->timestamps();

            $table->foreign('company_id')->references('id')->on('companies');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipments');
    }
};
