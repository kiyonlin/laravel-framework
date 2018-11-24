<?php

namespace Kiyon\Laravel\Console\Commands\ModMake;

use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;

class ModRepositoryContractMakeCommand extends GeneratorCommand
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'mod-make:repository-contract';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '创建系统模块仓库接口';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Contracts';


    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__ . '/stubs/repository.contract.stub';
    }

    /**
     * Get the destination class path.
     *
     * @param  string $name
     * @return string
     */
    public function getPath($name)
    {
        $name = Str::replaceFirst($this->rootNamespace(), '', $name);

        $name .= 'RepositoryContract';

        return $this->laravel['path'] . '/Modules/' . $this->getModuleInput() . str_replace('\\', '/', $name) . '.php';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\\' .$this->type;
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
        ];
    }
}
