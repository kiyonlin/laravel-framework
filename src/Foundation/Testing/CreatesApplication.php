<?php

namespace Kiyon\Laravel\Foundation\Testing;

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Filesystem\Filesystem;

trait CreatesApplication
{

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        dd(base_path());

        $app = require realpath('./') . '/bootstrap/app.php';

        $app->make(Kernel::class)->bootstrap();

        // 使用测试环境时，强制删除config缓存
        $files = new Filesystem();
        if ($files->exists($configConfigPath = $app->getCachedConfigPath())) {
            $files->delete($configConfigPath);
        }

        // 使用测试环境时，强制删除route缓存
        if ($files->exists($configRoutesPath = $app->getCachedRoutesPath())) {
            $files->delete($configConfigPath);
        }

        return $app;
    }
}
