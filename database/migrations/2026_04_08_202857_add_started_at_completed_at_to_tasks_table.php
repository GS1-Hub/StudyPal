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
        Schema::table('tasks', function (Blueprint $table) {
            $table->timestamp('started_at')->nullable()->after('due_date');
            $table->timestamp('completed_at')->nullable()->after('started_at');
            $table->dropColumn('completed'); // remove a coluna antiga
        });
    }

    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropColumn(['started_at', 'completed_at']);
            $table->boolean('completed')->default(false); // restaura se fizeres rollback
        });
    }
};
