<?php

namespace Naust\RepositoryCommand\Providers;

use Illuminate\Support\ServiceProvider;
use Naust\RepositoryCommand\Console\ContractMakeCommand;
use Naust\RepositoryCommand\Console\RepositoryMakeCommand;

/**
 * Created by PhpStorm.
 * User: haugen
 * Date: 09.03.2017
 * Time: 14.25.
 */
class RepositoryCommandProvider extends ServiceProvider
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
