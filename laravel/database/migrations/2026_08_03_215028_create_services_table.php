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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('service_categories')->onDelete('cascade');
            $table->string('title', 150);
            $table->string('slug', 150)->unique();
            $table->string('tagline', 150);
            $table->text('description');
            $table->string('starting_price', 50);
            $table->string('average_duration', 50);
            $table->string('hero_image', 255);
            $table->text('what_is_brief');
            $table->string('docs_title', 255)->default('Documents Needed. Keep Them Ready.');
            $table->string('docs_subtitle', 255)->default('Scanned copies are sufficient. No physical originals are required for submission.');
            $table->text('pillars_json');
            $table->text('steps_json');
            $table->text('deliverables_json');
            $table->text('pricing_packages_json');
            $table->text('faqs_json');
            $table->text('docs_json')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
