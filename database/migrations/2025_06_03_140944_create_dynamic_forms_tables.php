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
        Schema::create('document_types', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->text('description')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
        });

        Schema::create('form_fields', function (Blueprint $table) {
            $table->id();
            $table->foreignId('document_type_id')->constrained('document_types')->onDelete('cascade');
            $table->string('field_name');
            $table->string('field_label');
            $table->string('field_type', 50);
            $table->string('field_options')->nullable();
            $table->string('field_checkbox_options')->nullable();
            $table->boolean('is_required')->default(false);
            $table->integer('order')->default(0);
            // $table->boolean('is_header')->default(false);
            $table->string('hint')->nullable();
            $table->timestamps();

            $table->index(['document_type_id', 'order']);
        });

        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('document_type_id')->constrained('document_types')->onDelete('cascade');
            // $table->string('title');
            $table->string('number')->unique();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->date('active_date')->nullable();
            // $table->integer('order')->default(1);
            $table->timestamps();
        });

        Schema::create('document_field_values', function (Blueprint $table) {
            $table->id();
            $table->foreignId('document_id')->constrained('documents')->onDelete('cascade');
            $table->foreignId('form_field_id')->constrained('form_fields')->onDelete('cascade');
            $table->text('value')->nullable();
            $table->timestamps();

            $table->unique(['document_id', 'form_field_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Urutan drop tabel harus terbalik dari urutan create
        // Drop tabel anak dulu sebelum tabel induk
        Schema::dropIfExists('document_field_values');
        Schema::dropIfExists('documents');
        Schema::dropIfExists('form_fields');
        Schema::dropIfExists('document_types');
    }
};
