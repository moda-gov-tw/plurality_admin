<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Contracts\NewsContract;
use App\Repositories\NewsRepository;
use App\Contracts\ExhibitionContract;
use App\Repositories\ExhibitionRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    protected $repositories = [
        
        NewsContract::class             =>          NewsRepository::class,
        ExhibitionContract::class       =>          ExhibitionRepository::class,
    ];

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        foreach ($this->repositories as $interface => $implementation)
        {
            $this->app->bind($interface, $implementation);
        }
    }
}