<?php

use App\Models\Employer;
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
        Schema::create('employer_addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Employer::class)->constrained()->cascadeOnDelete();
            $table->string('street');
            $table->string('barangay');
            $table->string('city');
            $table->string('province');
            $table->string('zip_code');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employer_addresses');
    }
};
