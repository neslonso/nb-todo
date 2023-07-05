<?php

use App\Models\Category;
use App\Models\Task;
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
        Schema::create('category_task', function (Blueprint $table) {
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->foreignId('task_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            $table->primary(['category_id', 'task_id']);
            $table->index('category_id');
            $table->index('task_id');
        });

        if (App::isLocal() || App::runningUnitTests()) {
            User::factory()->create([
                'id' => config('local.testing.user.id'),
                'name' => config('local.testing.user.name'),
                'email' => config('local.testing.user.email'),
                'password' => config('local.testing.user.password'),
            ]);

            User::factory()
                ->count(2)
                ->create()
            ;

            DB::table('categories')->insert([
                ['name' => 'PHP', 'created_at' => now(), 'updated_at' => null],
                ['name' => 'JS', 'created_at' => now(), 'updated_at' => null],
                ['name' => 'CSS', 'created_at' => now(), 'updated_at' => null],
                ['name' => 'Otros', 'created_at' => now(), 'updated_at' => null],
            ]);

            Category::factory()
                ->count(9)
                ->create()
            ;

            Task::factory()
                ->count(13)
                ->create()
            ;

            /*
             * Ambos efoques tienen rendimiento similar, al menos para bajo número de registros.
             */
            // $this->insertRelationsA();
            $this->insertRelationsB();
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('category_task');
    }

    private function insertRelationsA()
    {
        $tasks = Task::all();
        $categories = Category::all();

        foreach ($tasks as $task) {
            $randomCategories = $categories->random(rand(2, 5));

            $task->categories()->attach($randomCategories, [
                'created_at' => now(),
                'updated_at' => null,
            ]);
        }
    }

    private function insertRelationsB()
    {
        $taskIds = Task::pluck('id')->all();
        $categoryIds = Category::pluck('id')->all();

        foreach ($taskIds as $taskId) {
            $randomKeys = array_rand($categoryIds, rand(2, 5));
            foreach ($randomKeys as $randomKey) {
                DB::table('category_task')->insert([
                    'category_id' => $categoryIds[$randomKey],
                    'task_id' => $taskId,
                    'created_at' => now(),
                    'updated_at' => null,
                ]);
            }
        }
    }
};
