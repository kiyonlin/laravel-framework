<?php

namespace Kiyon\Laravel\Console;

use Symfony\Component\Console\Input\InputOption;

class ModControllerMakeCommand extends GeneratorCommand
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'mod-make:controller';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '创建系统模块控制器';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Controller';


    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        if ($this->option('plain')) {
            return __DIR__ . '/stubs/controller.plain.stub';
        }

        return __DIR__ . '/stubs/controller.stub';
    }

    /**
     * Build the class with the given name.
     *
     * @param  string $name
     * @return string
     */
    public function buildClass($name)
    {
        $stub = $this->files->get($this->getStub());

        return $this->replaceNamespace($stub, $name)
            ->replaceClass($stub, $name)
            ->replaceTable($stub);
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
            ['plain', 'p', InputOption::VALUE_NONE, 'Create the plain controller class'],
        ];
    }
}
