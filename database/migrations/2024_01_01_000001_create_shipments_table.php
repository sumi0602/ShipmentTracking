<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shipments', function (Blueprint $table) {
            $table->id();
            $table->string('tracking_number', 20)->unique();
            $table->string('sender_name');
            $table->text('sender_address');
            $table->string('receiver_name');
            $table->text('receiver_address');
            $table->string('destination_city');
            $table->enum('status', ['Pending', 'In Transit', 'Delivered'])
                  ->default('Pending');
            $table->timestamps();

            $table->index(['tracking_number', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shipments');
    }
};
