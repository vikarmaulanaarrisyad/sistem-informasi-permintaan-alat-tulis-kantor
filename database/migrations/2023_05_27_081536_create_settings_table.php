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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('owner_name');
            $table->string('email')
                ->unique();
            $table->string('phone');
            $table->text('about')
                ->nullable();
            $table->string('address')
                ->nullable();
            $table->char('postal_code', 5)
            ->nullable();
            $table->string('city')
                ->nullable();
            $table->string('province')
                ->nullable();
            $table->string('path_image')
                ->nullable();
            $table->string('path_image_header')
            ->nullable();
            $table->string('path_image_footer')
            ->nullable();
            $table->string('instagram_link');
            $table->string('twitter_link');
            $table->string('fanpage_link');
            $table->string('google_plus_link');
            $table->string('company_name');
            $table->string('short_description');
            $table->string('keyword');
            $table->string('phone_hours');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
