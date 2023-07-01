<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        if (App::isLocal() || App::runningUnitTests()) {
            $user = User::factory()->create([
                'id' => config('local.testing.user.id'),
                'name' => config('local.testing.user.name'),
                'email' => config('local.testing.user.email'),
                'password' => config('local.testing.user.password'),
            ]);
            User::factory()
                ->count(2)
                ->create();
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
