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
}