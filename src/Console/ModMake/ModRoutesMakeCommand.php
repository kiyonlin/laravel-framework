<?php

namespace Kiyon\Laravel\Console\ModMake;

use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;

class ModRoutesMakeCommand extends GeneratorCommand
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'mod-make:routes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '创建系统模块路由';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'routes';


    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__ . '/stubs/routes.stub';
    }

    /**
     * {@inheritdoc}
     */
    protected function getPath($name)
    {
        $name = Str::replaceFirst($this->rootNamespace(), '', $name);

        if ($this->argument('name')) {
            $replaceName = trim($this->argument('name'));
        } else {
            $replaceName = 'api';
        }

        $name = Str::replaceFirst($this->getModuleInput(), $replaceName, $name);

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
