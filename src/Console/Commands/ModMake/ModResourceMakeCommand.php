<?php

namespace Kiyon\Laravel\Console\Commands\ModMake;

use Symfony\Component\Console\Input\InputOption;

class ModResourceMakeCommand extends GeneratorCommand
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'mod-make:resource';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '创建系统模块资源';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Resource';


    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__ . '/stubs/resource.stub';
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
        ];
    }
}
