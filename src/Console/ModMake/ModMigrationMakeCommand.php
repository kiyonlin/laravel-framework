<?php

namespace Kiyon\Laravel\Console\ModMake;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;

class ModMigrationMakeCommand extends GeneratorCommand
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'mod-make:migration';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '创建系统模块迁移文件';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Migration';


    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__ . '/stubs/migration.create.stub';
    }

    /**
     * {@inheritdoc}
     */
    protected function getPath($name)
    {
        $name = '/database/migrations/' . $this->getPrefix() . '_create_app_' . Str::snake($this->getNameInput()) . 's_table';

        return $this->laravel['path'] . '/Modules/' . $this->getModuleInput() . str_replace('\\', '/', $name) . '.php';
    }

    protected function getPrefix()
    {
        return Carbon::now()->format('Y_m_d_His');
    }

    /**
     * {@inheritdoc}
     */
    protected function buildClass($name)
    {
        $stub = $this->files->get($this->getStub());

        $class = 'CreateApp' . $this->getNameInput() . 'sTable';

        $stub = str_replace('DummyMigrationClass', $class, $stub);

        return $this->replaceTable($stub);
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
