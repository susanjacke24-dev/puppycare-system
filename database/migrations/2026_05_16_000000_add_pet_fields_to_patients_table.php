<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            $table->string('pet_name')->nullable()->after('user_id');
            $table->string('species')->nullable()->after('pet_name');
            $table->string('breed')->nullable()->after('species');
            $table->string('sex')->nullable()->after('breed');
            $table->date('birth_date')->nullable()->after('sex');
        });
    }

    public function down(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            $table->dropColumn(['pet_name', 'species', 'breed', 'sex', 'birth_date']);
        });
    }
};
