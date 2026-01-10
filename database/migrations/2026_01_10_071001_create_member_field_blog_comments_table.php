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
        Schema::create('member_field_blog_comments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->text('comment');
            $table->enum('status', ['approved', 'spam'])->default('approved');
            $table->foreignId('parent_id')->nullable()->constrained('member_field_blog_comments')->onDelete('cascade');
            $table->foreignId('member_field_blog_id')->constrained('member_field_blogs')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->softDeletes();
            $table->timestamps();

            $table->index('status');
            $table->index('member_field_blog_id');
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('member_field_blog_comments');
    }
};
