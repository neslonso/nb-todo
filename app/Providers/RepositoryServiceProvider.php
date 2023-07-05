<?php

namespace App\Providers;

use App\Core\Infrastructure\CategoryRepositoryInterface;
use App\Core\Infrastructure\Eloquent\EloquentCategoryRepository;
use App\Core\Infrastructure\Eloquent\EloquentTaskRepository;
use App\Core\Infrastructure\TaskRepositoryInterface;
use App\Models\Category;
use App\Models\Task;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(TaskRepositoryInterface::class, function ($app) {
            return new EloquentTaskRepository(new Task());
        });

        $this->app->bind(CategoryRepositoryInterface::class, function ($app) {
            return new EloquentCategoryRepository(new Category());
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
    }
}
