<?php

namespace Naust\ArtisanBooster\Providers;

use Illuminate\Support\ServiceProvider;
use Naust\ArtisanBooster\Console\ContractMakeCommand;
use Naust\ArtisanBooster\Console\RepositoryMakeCommand;

/**
 * Created by PhpStorm.
 * User: haugen
 * Date: 09.03.2017
 * Time: 14.25.
 */
class ArtisanBoosterProvider extends ServiceProvider
{
    protected $commands = [
        ContractMakeCommand::class,
        RepositoryMakeCommand::class,
    ];

    public function register()
    {
        // Register commands
        $this->commands($this->commands);
    }
}
