<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jewelry_receives', function (Blueprint $table) {
            $table->id();
            $table->date('receive_date')->default(DB::raw('(CURRENT_DATE)'));
            $table->string('customer_name');
            $table->string('customer_phone', 50);
            $table->text('overall_note')->nullable();
            $table->unsignedInteger('total_items')->default(0);
            $table->decimal('total_value', 14, 2)->default(0);
            $table->enum('status', ['received', 'pending'])->default('received');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jewelry_receives');
    }
};

