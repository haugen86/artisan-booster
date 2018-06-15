<?php

namespace Naust\RepositoryCommand\Console;

use Illuminate\Support\Str;
use InvalidArgumentException;
use Symfony\Component\Console\Input\InputOption;

class RepositoryMakeCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'make:repository';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Repository class';

    protected $type = 'Repository';

    public function fire()
    {
        if (parent::fire() === false) {
            return;
        }
    }

    protected function createContract()
    {
        $contract = Str::studly(class_basename($this->argument('name')));
        $this->call('make:contract', [
            'name' => "{$contract}RepositoryContract",
        ]);
    }

    protected function getStub()
    {
        if ($this->option('model') && $this->option('contract')) {
            return __DIR__.'/stubs/repository.model.contract.stub';
        } elseif ($this->option('model')) {
            return __DIR__.'/stubs/repository.model.stub';
        } elseif ($this->option('contract')) {
            return __DIR__.'/stubs/repository.contract.stub';
        }

        return __DIR__.'/stubs/repository.plain.stub';
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\Repositories';
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['contract', 'c', InputOption::VALUE_OPTIONAL, 'Generate bindings to the given contract.'],
            ['package', 'p', InputOption::VALUE_OPTIONAL, 'Pass in namespace for the package. I.E. -p "Naust\Core"'],
            ['model', 'm', InputOption::VALUE_OPTIONAL, 'Generate bindings to the given model'],
        ];
    }

    protected function buildClass($name)
    {
        $replace = [];
        if ($this->option('model')) {
            $modelClass = $this->parseModel($this->option('model'));
            if (!class_exists($modelClass)) {
                if ($this->confirm("A {$modelClass} model does not exist. Do you want to generate it?", true)) {
                    $this->call('make:model', ['name' => $modelClass]);
                }
            }
            $replace = [
                'DummyFullModelClass' => $modelClass,
                'DummyModelClass' => class_basename($modelClass),
                'DummyModelVariable' => lcfirst(class_basename($modelClass)),
            ];
        }

        if ($this->option('contract')) {
            $contractName = $this->option('contract');
            $contractInterface = $this->parseContract($contractName);
            if (!interface_exists($contractInterface)) {
                if ($this->confirm("A {$contractInterface} contract does not exist. Do you want to generate it?", true)) {
                    $this->call('make:contract', [
                        'name' => $contractName,
                        '-p' => $this->option('package'),
                    ]);
                }
            }

            $replace['DummyFullContract'] = $contractInterface;
            $replace['DummyContract'] = $contractName;
            $replace['DummyRepositoryContract'] = $contractName;
        }

        return str_replace(
            array_keys($replace), array_values($replace), parent::buildClass($name)
        );
    }

    protected function parseModel($model)
    {
        if (preg_match('([^A-Za-z0-9_/\\\\])', $model)) {
            throw new InvalidArgumentException('Model name contains invalid characters.');
        }
        $model = trim(str_replace('/', '\\', $model), '\\');
        if (!Str::startsWith($model, $rootNamespace = $this->rootNamespace())) {
            $model = $rootNamespace.$model;
        }

        return $model;
    }

    protected function parseContract($contract)
    {
        if (preg_match('([^A-Za-z0-9_/\\\\])', $contract)) {
            throw new InvalidArgumentException('Contract name contains invalid characters.');
        }
        $contract = trim(str_replace('/', '\\', $contract), '\\');
        if (!Str::startsWith($contract, $rootNamespace = $this->rootNamespace().'Contracts\\')) {
            $contract = $rootNamespace.$contract;
        }

        return $contract;
    }
}
