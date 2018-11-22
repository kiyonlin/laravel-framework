<?php

namespace Kiyon\Laravel\Console\ModMake;

use Symfony\Component\Console\Input\InputOption;

class ModFeatureTestMakeCommand extends GeneratorCommand
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'mod-make:feature-test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '创建系统模块功能测试';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Test';


    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__ . '/stubs/test.feature.stub';
    }

    /**
     * {@inheritdoc}
     */
    protected function getPath($name)
    {
        $name = '/Test/Feature/' . $this->getNameInput() . $this->type;

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
        return $rootNamespace . '\\' . $this->type . '\\Feature';
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
