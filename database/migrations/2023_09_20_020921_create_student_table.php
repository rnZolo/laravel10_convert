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
        Schema::create('student', function (Blueprint $table) {
            $table->id('id');
            $table->string('student_type', 191);
            $table->integer('id_number');
            $table->string('name', 191);
            $table->integer('age');
            $table->string('city', 191);
            $table->string('mobile_number', 191);
            $table->decimal('grades', 5, 2)->nullable();
            $table->string('gender', 191)->nullable();
            $table->string('email', 191);
            $table->timestamp('created_at')
                ->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')
                ->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student');
    }
};
