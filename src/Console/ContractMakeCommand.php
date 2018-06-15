<?php

namespace Naust\ArtisanBooster\Console;

use Symfony\Component\Console\Input\InputOption;

class ContractMakeCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'make:contract';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Contract interface';

    protected $type = 'Contract';

    public function handle()
    {
        if (parent::handle() === false) {
            return;
        }
    }

    protected function getStub()
    {
        return __DIR__.'/stubs/contract.stub';
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\Contracts';
    }

    protected function getOptions()
    {
        return [
            ['package', 'p', InputOption::VALUE_OPTIONAL, 'Pass in namespace for the package. I.E. -p "Naust\Core"'],
        ];
    }
}
