<?php

namespace Kiyon\Laravel\Console;

use Symfony\Component\Console\Input\InputOption;

class ModServiceProviderMakeCommand extends GeneratorCommand
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'mod-make:service-provider';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '创建系统模块服务提供者';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'ServiceProvider';


    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__ . '/stubs/service-provider.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace;
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
