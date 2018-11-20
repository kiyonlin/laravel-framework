<?php
/**
 * Created by IntelliJ IDEA.
 * User: kiyon
 * Date: 2018/11/20
 * Time: 1:49 PM
 */

namespace Tests\Feature\Console;


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
}