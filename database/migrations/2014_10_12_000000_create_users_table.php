<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
  {
    Schema::create('users', function (Blueprint $table) {
        $table->id('user_id');
        $table->string('username', 50)->unique();
        $table->string('password', 255);
        $table->string('full_name', 100);
        $table->string('email', 100)->unique();
        $table->enum('role', ['admin','team_lead','developer','designer'])->default('developer');
        $table->timestamp('created_at')->useCurrent();
        $table->enum('current_task_status', ['idle','working'])->default('idle');
     });
  }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
