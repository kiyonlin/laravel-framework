<?php
/**
 * Created by IntelliJ IDEA.
 * User: kiyon
 * Date: 2018/11/20
 * Time: 1:49 PM
 */

namespace Tests\Feature\Console;


use Carbon\Carbon;
use Tests\TestCase;

class ModuleMakeTest extends TestCase
{

    protected function setUp()
    {
        parent::setUp();

        $moduleDir = $this->app->basePath() . '/app/Modules';

        $this->app['files']->deleteDirectory($moduleDir);
    }

    /** @test */
    public function 模型创建命令()
    {
        $this->artisan('mod-make:model', ['mod' => 'Module'])->run();

        $modelFile = $this->app->basePath() . '/app/Modules/Module/Model/Module.php';

        $this->assertFileExists($modelFile);

        $this->artisan('mod-make:model', ['mod' => 'Module', 'name' => 'FakeModel'])->run();

        $modelFile = $this->app->basePath() . '/app/Modules/Module/Model/FakeModel.php';

        $this->assertFileExists($modelFile);
    }

    /** @test */
    public function 空白控制器创建命令()
    {
        $this->artisan('mod-make:controller', ['mod' => 'Module', '-p' => true])->run();

        $controllerFile = $this->app->basePath() . '/app/Modules/Module/Controller/ModuleController.php';

        $this->assertFileExists($controllerFile);

        $this->artisan('mod-make:controller', ['mod' => 'Module', 'name' => 'Fake', '-p' => true])->run();

        $controllerFile = $this->app->basePath() . '/app/Modules/Module/Controller/FakeController.php';

        $this->assertFileExists($controllerFile);
    }

    /** @test */
    public function restful控制器创建命令()
    {
        $this->artisan('mod-make:controller', ['mod' => 'Module'])->run();

        $controllerFile = $this->app->basePath() . '/app/Modules/Module/Controller/ModuleController.php';

        $this->assertFileExists($controllerFile);

        $this->artisan('mod-make:controller', ['mod' => 'Module', 'name' => 'Fake'])->run();

        $controllerFile = $this->app->basePath() . '/app/Modules/Module/Controller/FakeController.php';

        $this->assertFileExists($controllerFile);
    }

    /** @test */
    public function 仓库创建命令()
    {
        $this->artisan('mod-make:repository', ['mod' => 'Module'])->run();

        $repositoryFile = $this->app->basePath() . '/app/Modules/Module/Repository/ModuleRepository.php';
        $contractFile = $this->app->basePath() . '/app/Modules/Module/Contracts/ModuleRepositoryContract.php';

        $this->assertFileExists($repositoryFile);
        $this->assertFileExists($contractFile);

        $this->artisan('mod-make:repository', ['mod' => 'Module', 'name' => 'Fake'])->run();

        $repositoryFile = $this->app->basePath() . '/app/Modules/Module/Repository/FakeRepository.php';
        $contractFile = $this->app->basePath() . '/app/Modules/Module/Contracts/FakeRepositoryContract.php';

        $this->assertFileExists($repositoryFile);
        $this->assertFileExists($contractFile);
    }

    /** @test */
    public function 空白仓库创建命令()
    {
        $this->artisan('mod-make:repository', ['mod' => 'Module', '--plain' => true])->run();

        $repositoryFile = $this->app->basePath() . '/app/Modules/Module/Repository/ModuleRepository.php';
        $contractFile = $this->app->basePath() . '/app/Modules/Module/Contracts/ModuleRepositoryContract.php';

        $this->assertFileExists($repositoryFile);
        $this->assertFileNotExists($contractFile);

        $this->artisan('mod-make:repository', ['mod' => 'Module', 'name' => 'Fake', '--plain' => true])->run();

        $repositoryFile = $this->app->basePath() . '/app/Modules/Module/Repository/FakeRepository.php';
        $contractFile = $this->app->basePath() . '/app/Modules/Module/Contracts/FakeRepositoryContract.php';

        $this->assertFileExists($repositoryFile);
        $this->assertFileNotExists($contractFile);
    }

    /** @test */
    public function 服务创建命令()
    {
        $this->artisan('mod-make:service', ['mod' => 'Module'])->run();

        $serviceFile = $this->app->basePath() . '/app/Modules/Module/Service/ModuleService.php';

        $this->assertFileExists($serviceFile);

        $this->artisan('mod-make:service', ['mod' => 'Module', 'name' => 'Fake'])->run();

        $serviceFile = $this->app->basePath() . '/app/Modules/Module/Service/FakeService.php';

        $this->assertFileExists($serviceFile);
    }

    /** @test */
    public function 服务提供者创建命令()
    {
        $this->artisan('mod-make:service-provider', ['mod' => 'Module'])->run();

        $serviceProviderFile = $this->app->basePath() . '/app/Modules/Module/ModuleServiceProvider.php';

        $this->assertFileExists($serviceProviderFile);

        $this->artisan('mod-make:service-provider', ['mod' => 'Module', 'name' => 'Fake'])->run();

        $serviceProviderFile = $this->app->basePath() . '/app/Modules/Module/FakeServiceProvider.php';

        $this->assertFileExists($serviceProviderFile);
    }

    /** @test */
    public function 服务提供者创建路由()
    {
        $this->artisan('mod-make:routes', ['mod' => 'Module'])->run();

        $routesFile = $this->app->basePath() . '/app/Modules/Module/routes/api.php';

        $this->assertFileExists($routesFile);
    }

    /** @test */
    public function 服务提供者创建迁移文件()
    {
        Carbon::setTestNow('2018-11-21 08:57:22');

        $this->artisan('mod-make:migration', ['mod' => 'Module'])->run();

        $migrationFile = $this->app->basePath() . '/app/Modules/Module/database/migrations/2018_11_21_085722_create_app_modules_table.php';

        $this->assertFileExists($migrationFile);

        $this->artisan('mod-make:migration', ['mod' => 'Module', 'name' => 'FakeModel'])->run();

        $migrationFile = $this->app->basePath() . '/app/Modules/Module/database/migrations/2018_11_21_085722_create_app_fake_models_table.php';

        $this->assertFileExists($migrationFile);
    }

    /** @test */
    public function 服务提供者创建数据填充()
    {
        $this->artisan('mod-make:factory', ['mod' => 'Module'])->run();

        $factoryFile = $this->app->basePath() . '/app/Modules/Module/database/factories/ModuleFactory.php';

        $this->assertFileExists($factoryFile);

        $this->artisan('mod-make:factory', ['mod' => 'Module', 'name' => 'FakeModel'])->run();

        $factoryFile = $this->app->basePath() . '/app/Modules/Module/database/factories/FakeModelFactory.php';

        $this->assertFileExists($factoryFile);
    }
}