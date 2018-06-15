<?php
namespace Lx3\RepositoryCommand\Providers;

use Illuminate\Support\ServiceProvider;
use Lx3\RepositoryCommand\Console\ContractMakeCommand;
use Lx3\RepositoryCommand\Console\RepositoryMakeCommand;

/**
 * Created by PhpStorm.
 * User: haugen
 * Date: 09.03.2017
 * Time: 14.25
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