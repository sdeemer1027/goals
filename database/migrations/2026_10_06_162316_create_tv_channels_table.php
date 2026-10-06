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
        Schema::create('tv_channels', function (Blueprint $table) {
            $table->id();

            $table->string('provider'); // Pluto TV, Tubi TV, etc.
            $table->string('name');
            $table->string('slug')->unique();

            $table->string('logo_url')->nullable();
            $table->text('description')->nullable();

            $table->string('category')->nullable();

            $table->string('stream_type')->nullable();
            $table->text('stream_url')->nullable();
            $table->text('embed_url')->nullable();
            $table->text('external_url')->nullable();

            $table->boolean('active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);

            $table->timestamps();

            $table->index(['provider', 'active']);
            $table->index(['category', 'active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tv_channels');
    }
};