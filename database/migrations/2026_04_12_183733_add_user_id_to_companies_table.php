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
        Schema::table('companies', function (Blueprint $table) {
            if (!Schema::hasColumn('companies', 'user_id')) {
                $table->foreignId('user_id')->nullable()->after('id')->constrained()->onDelete('cascade');
            } else {
                // Column was added by a previously failed migration attempt (without FK).
                // Null out any invalid (non-existent user) values, make nullable, then add FK.
                \DB::statement('UPDATE companies SET user_id = NULL WHERE user_id NOT IN (SELECT id FROM users)');
                $table->unsignedBigInteger('user_id')->nullable()->change();
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            }
        });
    }

    public function down(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
};
