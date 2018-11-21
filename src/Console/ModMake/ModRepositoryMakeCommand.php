<?php

namespace Kiyon\Laravel\Console\ModMake;

use Symfony\Component\Console\Input\InputOption;

class ModRepositoryMakeCommand extends GeneratorCommand
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'mod-make:repository';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '创建系统模块仓库';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Repository';

    public function handle()
    {
        parent::handle();

        if (! $this->option('plain')) {
            $this->call('mod-make:repository-contract', [
                'mod'  => $this->argument('mod'),
                'name' => $this->argument('name'),
            ]);
        }
    }


    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__ . '/stubs/repository.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\\' . $this->type;
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['force', null, InputOption::VALUE_NONE, 'Create the class even if the model already exists'],
            ['plain', 'p', InputOption::VALUE_NONE, 'Create the contract class'],
        ];
    }
}
