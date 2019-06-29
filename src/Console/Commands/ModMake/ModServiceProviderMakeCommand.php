<?php

namespace Kiyon\Laravel\Console\Commands\ModMake;

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

    public function handle()
    {
        parent::handle();

        $this->insertToAppServiceProvider();
    }

    /**
     * 插入新的service provider到AppServiceProvider.php文件中
     */
    private function insertToAppServiceProvider()
    {
        $name = $this->qualifyClass($this->getNameInput());
        $insertContents = "\\{$name}ServiceProvider::class,";

        $path = $this->laravel['path'] . '/Providers/AppServiceProvider.php';
        $contents = file_get_contents($path);

        $newContents = preg_replace(
            '/protected\s+\$providers\s*=\s*\[(.*)\]/is',
            <<<"HD"
protected \$providers = [$1    {$insertContents}
    ]
HD,
            $contents);

        file_put_contents($path, $newContents);
    }

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
     * @param string $rootNamespace
     *
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
