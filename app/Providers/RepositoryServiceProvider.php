<?php

namespace App\Providers;

use App\Repositories\Contracts\DashboardContract;
use App\Repositories\DashboardRepository;
use App\Repositories\Contracts\QuestionContract;
use App\Repositories\QuestionRepository;
use App\Repositories\Contracts\PackageContract;
use App\Repositories\PackageRepository;
use App\Repositories\Contracts\QuestionTypeContract;
use App\Repositories\QuestionTypeRepository;
use App\Repositories\Contracts\UserContract;
use App\Repositories\UserRepository;
use App\Repositories\Contracts\WalletContract;
use App\Repositories\WalletRepository;
use App\Repositories\Contracts\TransactionContract;
use App\Repositories\TransactionRepository;
use App\Repositories\Contracts\ExamContract;
use App\Repositories\ExamRepository;
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
        $this->app->singleton(
            DashboardContract::class,
            DashboardRepository::class
        );

        $this->app->singleton(
            QuestionContract::class,
            QuestionRepository::class
        );

        $this->app->singleton(
            PackageContract::class,
            PackageRepository::class
        );

        $this->app->singleton(
            QuestionTypeContract::class,
            QuestionTypeRepository::class
        );

        $this->app->singleton(
            UserContract::class,
            UserRepository::class
        );

        $this->app->singleton(
            WalletContract::class,
            WalletRepository::class
        );

        $this->app->singleton(
            TransactionContract::class,
            TransactionRepository::class
        );

        $this->app->singleton(
            ExamContract::class,
            ExamRepository::class
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
