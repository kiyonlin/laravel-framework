<?php

namespace Kiyon\Laravel\Console\ModMake;

use Symfony\Component\Console\Input\InputOption;

class ModRequestMakeCommand extends GeneratorCommand
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'mod-make:request';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '创建系统模块请求验证';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Request';


    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__ . '/stubs/request.stub';
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
