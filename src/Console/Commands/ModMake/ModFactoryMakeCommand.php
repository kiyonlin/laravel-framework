<?php

namespace Kiyon\Laravel\Console\Commands\ModMake;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;

class ModFactoryMakeCommand extends GeneratorCommand
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'mod-make:factory';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '创建系统模块数据填充';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Factory';


    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__ . '/stubs/factory.stub';
    }

    /**
     * {@inheritdoc}
     */
    protected function getPath($name)
    {
        $name = '/database/factories/' . $this->getNameInput() . $this->type;

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
