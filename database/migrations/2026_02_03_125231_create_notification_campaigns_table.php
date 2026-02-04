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
        Schema::create('notification_campaigns', function (Blueprint $table) {
            $table->id();
        $table->string('title');
        $table->text('body');
        $table->string('link')->nullable();
        $table->string('image_url')->nullable();
        $table->enum('type', ['general', 'article', 'promotion', 'update']);
        $table->enum('status', ['draft', 'scheduled', 'sending', 'sent', 'failed']);
        $table->json('target_categories');
        $table->integer('recipients_count');
        $table->integer('delivered_count');
        $table->integer('opened_count');
        $table->integer('clicked_count');
        $table->timestamp('scheduled_at')->nullable();
        $table->timestamp('sent_at')->nullable();
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notification_campaigns');
    }
};
