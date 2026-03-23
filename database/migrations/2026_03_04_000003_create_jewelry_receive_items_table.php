<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jewelry_receive_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jewelry_receive_id')->constrained('jewelry_receives')->cascadeOnDelete();

            $table->string('type', 100);
            $table->decimal('kyat', 8, 2)->nullable();
            $table->decimal('pae', 8, 2)->nullable();
            $table->decimal('yway', 8, 2)->nullable();
            $table->decimal('point', 8, 2)->nullable();
            $table->string('color', 50);
            $table->decimal('price', 14, 2)->default(0);
            $table->string('remark')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jewelry_receive_items');
    }
};

