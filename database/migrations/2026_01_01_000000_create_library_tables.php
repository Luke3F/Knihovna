<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('books', function (Blueprint $t) {
            $t->id();
            $t->string('title');
            $t->string('author');
            $t->string('isbn', 13)->unique();           // 13 znaků, unikátní
            $t->unsignedInteger('available_copies')->default(0); // >= 0
            $t->timestamps();
        });
        Schema::create('readers', function (Blueprint $t) {
            $t->id();
            $t->string('name');
            $t->string('email')->unique();
            $t->timestamps();
        });
        Schema::create('loans', function (Blueprint $t) {
            $t->id();
            $t->foreignId('book_id')->constrained()->restrictOnDelete();
            $t->foreignId('reader_id')->constrained()->restrictOnDelete();
            $t->dateTime('borrowed_at');
            $t->dateTime('due_at');
            $t->dateTime('returned_at')->nullable();
            $t->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('loans');
        Schema::dropIfExists('readers');
        Schema::dropIfExists('books');
    }
};
