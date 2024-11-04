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
        // Check if the 'combo_video' table exists
        if (!Schema::hasTable('combo_video')) {
            Schema::create('combo_video', function (Blueprint $table) {
                $table->id(); 
                $table->unsignedBigInteger('ref_id'); 
                $table->string('model'); 
                $table->timestamps(); 
            });
        }
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('combo_video');
    }
};
