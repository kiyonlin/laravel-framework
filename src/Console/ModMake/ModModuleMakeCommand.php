<?php

namespace Kiyon\Laravel\Console\ModMake;

use Illuminate\Support\Str;
use Kiyon\Laravel\Console\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class ModModuleMakeCommand extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'mod-make:module';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '创建系统模块';

    protected $makeOptions = [
        'all', 'model', 'repository', 'request', 'controller', 'service', 'service-provider',
        'routes', 'factory', 'migration', 'unit-test', 'feature-test',
    ];


    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->output->title('开始创建应用模块');
        $customerModule = $this->ask("自定义模块内容?(y/n)", 'n');
        $customerModule = Str::substr(Str::lower($customerModule), 0, 1);

        $choices = $this->makeOptions;

        if ($customerModule != 'n') {
            $choices = $this->choice('请选择需要创建的模块内容(可多选，使用逗号隔开)',
                $this->makeOptions, null, 1, true);
        }

        if (in_array('all', $choices)) {
            $choices = array_except($this->makeOptions, '0');
        }

        foreach ($choices as $choice) {
            $this->call("mod-make:{$choice}", [
                'mod'     => $this->argument('mod'),
                'name'    => $this->argument('name'),
                '--force' => $this->option('force'),
            ]);
        }
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['mod', InputArgument::REQUIRED, 'The name of the module'],
            ['name', InputArgument::OPTIONAL, 'The name of the class'],
        ];
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
