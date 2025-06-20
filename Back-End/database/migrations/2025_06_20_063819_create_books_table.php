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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string("image")->nullable();
            $table->string("Isnb",20)->unique();
            $table->string("title",150);
            $table->string("author",150);
            $table->integer("Publication_years");
            $table->integer("Number_of_Copies")->default(0);
            $table->string("Categories",100);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
