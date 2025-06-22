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
        $table->string("isbn", 20)->unique();
        $table->string("title", 150);
        $table->string("author", 150);
        $table->year("publication_year");
        $table->integer("number_of_copies")->default(0);
        $table->string("category", 100);
        $table->enum("priority", ["Low", "Medium", "High"])->default("Medium"); // 👈 Added priority
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
