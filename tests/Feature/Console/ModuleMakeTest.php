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

        $this->artisan('mod-make:model', ['mod' => 'Module', 'name' => 'Apply'])->run();

        $modelFile = $this->app->basePath() . '/app/Modules/Module/Model/Apply.php';

        $this->assertFileExists($modelFile);
    }

    /** @test */
    public function 空白控制器创建命令()
    {
        $this->artisan('mod-make:controller', ['mod' => 'Module', '-p' => true])->run();

        $controllerFile = $this->app->basePath() . '/app/Modules/Module/Controller/ModuleController.php';

        $this->assertFileExists($controllerFile);

        $this->artisan('mod-make:controller', ['mod' => 'Module', 'name' => 'Apply', '-p' => true])->run();

        $controllerFile = $this->app->basePath() . '/app/Modules/Module/Controller/ApplyController.php';

        $this->assertFileExists($controllerFile);
    }

    /** @test */
    public function restful控制器创建命令()
    {
        $this->artisan('mod-make:controller', ['mod' => 'Module'])->run();

        $controllerFile = $this->app->basePath() . '/app/Modules/Module/Controller/ModuleController.php';

        $this->assertFileExists($controllerFile);

        $this->artisan('mod-make:controller', ['mod' => 'Module', 'name' => 'Apply'])->run();

        $controllerFile = $this->app->basePath() . '/app/Modules/Module/Controller/ApplyController.php';

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

        $this->artisan('mod-make:repository', ['mod' => 'Module', 'name' => 'Apply'])->run();

        $repositoryFile = $this->app->basePath() . '/app/Modules/Module/Repository/ApplyRepository.php';
        $contractFile = $this->app->basePath() . '/app/Modules/Module/Contracts/ApplyRepositoryContract.php';

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

        $this->artisan('mod-make:repository', ['mod' => 'Module', 'name' => 'Apply', '--plain' => true])->run();

        $repositoryFile = $this->app->basePath() . '/app/Modules/Module/Repository/ApplyRepository.php';
        $contractFile = $this->app->basePath() . '/app/Modules/Module/Contracts/ApplyRepositoryContract.php';

        $this->assertFileExists($repositoryFile);
        $this->assertFileNotExists($contractFile);
    }

    /** @test */
    public function 服务创建命令()
    {
        $this->artisan('mod-make:service', ['mod' => 'Module'])->run();

        $serviceFile = $this->app->basePath() . '/app/Modules/Module/Service/ModuleService.php';

        $this->assertFileExists($serviceFile);

        $this->artisan('mod-make:service', ['mod' => 'Module', 'name' => 'Apply'])->run();

        $serviceFile = $this->app->basePath() . '/app/Modules/Module/Service/ApplyService.php';

        $this->assertFileExists($serviceFile);
    }

    /** @test */
    public function 服务提供者创建命令()
    {
        $this->artisan('mod-make:service-provider', ['mod' => 'Module'])->run();

        $serviceProviderFile = $this->app->basePath() . '/app/Modules/Module/ModuleServiceProvider.php';

        $this->assertFileExists($serviceProviderFile);

        $this->artisan('mod-make:service-provider', ['mod' => 'Module', 'name' => 'Apply'])->run();

        $serviceProviderFile = $this->app->basePath() . '/app/Modules/Module/ApplyServiceProvider.php';

        $this->assertFileExists($serviceProviderFile);
    }

    /** @test */
    public function 创建路由命令()
    {
        $this->artisan('mod-make:routes', ['mod' => 'Module'])->run();

        $routesFile = $this->app->basePath() . '/app/Modules/Module/routes/api.php';

        $this->assertFileExists($routesFile);
    }

    /** @test */
    public function 创建迁移文件命令()
    {
        Carbon::setTestNow('2018-11-21 08:57:22');

        $this->artisan('mod-make:migration', ['mod' => 'Module'])->run();

        $migrationFile = $this->app->basePath() . '/app/Modules/Module/database/migrations/2018_11_21_085722_create_app_modules_table.php';

        $this->assertFileExists($migrationFile);

        $this->artisan('mod-make:migration', ['mod' => 'Module', 'name' => 'Apply'])->run();

        $migrationFile = $this->app->basePath() . '/app/Modules/Module/database/migrations/2018_11_21_085722_create_app_applies_table.php';

        $this->assertFileExists($migrationFile);
    }

    /** @test */
    public function 创建数据填充命令()
    {
        $this->artisan('mod-make:factory', ['mod' => 'Module'])->run();

        $factoryFile = $this->app->basePath() . '/app/Modules/Module/database/factories/ModuleFactory.php';

        $this->assertFileExists($factoryFile);

        $this->artisan('mod-make:factory', ['mod' => 'Module', 'name' => 'Apply'])->run();

        $factoryFile = $this->app->basePath() . '/app/Modules/Module/database/factories/ApplyFactory.php';

        $this->assertFileExists($factoryFile);
    }

    /** @test */
    public function 创建请求验证命令()
    {
        $this->artisan('mod-make:request', ['mod' => 'Module'])->run();

        $requestFile = $this->app->basePath() . '/app/Modules/Module/Request/ModuleRequest.php';

        $this->assertFileExists($requestFile);

        $this->artisan('mod-make:request', ['mod' => 'Module', 'name' => 'Apply'])->run();

        $requestFile = $this->app->basePath() . '/app/Modules/Module/Request/ApplyRequest.php';

        $this->assertFileExists($requestFile);
    }

    /** @test */
    public function 创建单元测试命令()
    {
        $this->artisan('mod-make:unit-test', ['mod' => 'Module'])->run();

        $unitTestFile = $this->app->basePath() . '/app/Modules/Module/Test/Unit/ModuleTest.php';

        $this->assertFileExists($unitTestFile);

        $this->artisan('mod-make:unit-test', ['mod' => 'Module', 'name' => 'Apply'])->run();

        $unitTestFile = $this->app->basePath() . '/app/Modules/Module/Test/Unit/ApplyTest.php';

        $this->assertFileExists($unitTestFile);
    }

    /** @test */
    public function 创建功能测试命令()
    {
        $this->artisan('mod-make:feature-test', ['mod' => 'Module'])->run();

        $featureTestFile = $this->app->basePath() . '/app/Modules/Module/Test/Feature/ModuleTest.php';

        $this->assertFileExists($featureTestFile);

        $this->artisan('mod-make:feature-test', ['mod' => 'Module', 'name' => 'Apply'])->run();

        $featureTestFile = $this->app->basePath() . '/app/Modules/Module/Test/Feature/ApplyTest.php';

        $this->assertFileExists($featureTestFile);
    }

    /** @test */
    public function 创建模块命令()
    {
        Carbon::setTestNow('2018-11-21 08:57:22');

        $this->artisan('mod-make:module', ['mod' => 'Module'])
            ->expectsQuestion('自定义模块内容?(y/n)', 'n')
            ->assertExitCode(0);

        $modelFile = $this->app->basePath() . '/app/Modules/Module/Model/Module.php';
        $this->assertFileExists($modelFile);

        $controllerFile = $this->app->basePath() . '/app/Modules/Module/Controller/ModuleController.php';
        $this->assertFileExists($controllerFile);

        $repositoryFile = $this->app->basePath() . '/app/Modules/Module/Repository/ModuleRepository.php';
        $contractFile = $this->app->basePath() . '/app/Modules/Module/Contracts/ModuleRepositoryContract.php';
        $this->assertFileExists($repositoryFile);
        $this->assertFileExists($contractFile);

        $serviceFile = $this->app->basePath() . '/app/Modules/Module/Service/ModuleService.php';
        $this->assertFileExists($serviceFile);

        $serviceProviderFile = $this->app->basePath() . '/app/Modules/Module/ModuleServiceProvider.php';
        $this->assertFileExists($serviceProviderFile);

        $routesFile = $this->app->basePath() . '/app/Modules/Module/routes/api.php';
        $this->assertFileExists($routesFile);

        $migrationFile = $this->app->basePath() . '/app/Modules/Module/database/migrations/2018_11_21_085722_create_app_modules_table.php';
        $this->assertFileExists($migrationFile);

        $factoryFile = $this->app->basePath() . '/app/Modules/Module/database/factories/ModuleFactory.php';
        $this->assertFileExists($factoryFile);

        $requestFile = $this->app->basePath() . '/app/Modules/Module/Request/ModuleRequest.php';
        $this->assertFileExists($requestFile);

        $unitTestFile = $this->app->basePath() . '/app/Modules/Module/Test/Unit/ModuleTest.php';
        $this->assertFileExists($unitTestFile);

        $featureTestFile = $this->app->basePath() . '/app/Modules/Module/Test/Feature/ModuleTest.php';
        $this->assertFileExists($featureTestFile);

        $this->artisan('mod-make:module', ['mod' => 'Module', 'name' => 'Apply'])
            ->expectsQuestion('自定义模块内容?(y/n)', 'n')
            ->assertExitCode(0);

        $modelFile = $this->app->basePath() . '/app/Modules/Module/Model/Apply.php';
        $this->assertFileExists($modelFile);

        $controllerFile = $this->app->basePath() . '/app/Modules/Module/Controller/ApplyController.php';
        $this->assertFileExists($controllerFile);

        $repositoryFile = $this->app->basePath() . '/app/Modules/Module/Repository/ApplyRepository.php';
        $contractFile = $this->app->basePath() . '/app/Modules/Module/Contracts/ApplyRepositoryContract.php';
        $this->assertFileExists($repositoryFile);
        $this->assertFileExists($contractFile);

        $serviceFile = $this->app->basePath() . '/app/Modules/Module/Service/ApplyService.php';
        $this->assertFileExists($serviceFile);

        $migrationFile = $this->app->basePath() . '/app/Modules/Module/database/migrations/2018_11_21_085722_create_app_applies_table.php';
        $this->assertFileExists($migrationFile);

        $factoryFile = $this->app->basePath() . '/app/Modules/Module/database/factories/ApplyFactory.php';
        $this->assertFileExists($factoryFile);

        $requestFile = $this->app->basePath() . '/app/Modules/Module/Request/ApplyRequest.php';
        $this->assertFileExists($requestFile);

        $unitTestFile = $this->app->basePath() . '/app/Modules/Module/Test/Unit/ApplyTest.php';
        $this->assertFileExists($unitTestFile);

        $featureTestFile = $this->app->basePath() . '/app/Modules/Module/Test/Feature/ApplyTest.php';
        $this->assertFileExists($featureTestFile);
    }

    /** @test */
    public function 选择创建模块所有内容命令()
    {
        Carbon::setTestNow('2018-11-21 08:57:22');

        $this->artisan('mod-make:module', ['mod' => 'Module'])
            ->expectsQuestion('自定义模块内容?(y/n)', 'y')
            ->expectsQuestion('请选择需要创建的模块内容(可多选，使用逗号隔开)', [0])
            ->assertExitCode(0);

        $modelFile = $this->app->basePath() . '/app/Modules/Module/Model/Module.php';
        $this->assertFileExists($modelFile);

        $controllerFile = $this->app->basePath() . '/app/Modules/Module/Controller/ModuleController.php';
        $this->assertFileExists($controllerFile);

        $repositoryFile = $this->app->basePath() . '/app/Modules/Module/Repository/ModuleRepository.php';
        $contractFile = $this->app->basePath() . '/app/Modules/Module/Contracts/ModuleRepositoryContract.php';
        $this->assertFileExists($repositoryFile);
        $this->assertFileExists($contractFile);

        $serviceFile = $this->app->basePath() . '/app/Modules/Module/Service/ModuleService.php';
        $this->assertFileExists($serviceFile);

        $serviceProviderFile = $this->app->basePath() . '/app/Modules/Module/ModuleServiceProvider.php';
        $this->assertFileExists($serviceProviderFile);

        $routesFile = $this->app->basePath() . '/app/Modules/Module/routes/api.php';
        $this->assertFileExists($routesFile);

        $migrationFile = $this->app->basePath() . '/app/Modules/Module/database/migrations/2018_11_21_085722_create_app_modules_table.php';
        $this->assertFileExists($migrationFile);

        $factoryFile = $this->app->basePath() . '/app/Modules/Module/database/factories/ModuleFactory.php';
        $this->assertFileExists($factoryFile);

        $requestFile = $this->app->basePath() . '/app/Modules/Module/Request/ModuleRequest.php';
        $this->assertFileExists($requestFile);

        $unitTestFile = $this->app->basePath() . '/app/Modules/Module/Test/Unit/ModuleTest.php';
        $this->assertFileExists($unitTestFile);

        $featureTestFile = $this->app->basePath() . '/app/Modules/Module/Test/Feature/ModuleTest.php';
        $this->assertFileExists($featureTestFile);
    }

    /** @test */
    public function 选择创建模块部分内容命令()
    {
        Carbon::setTestNow('2018-11-21 08:57:22');

        $makeOptions = [
            'all', 'model', 'repository', 'request', 'controller', 'service', 'service-provider',
            'routes', 'factory', 'migration', 'unit-test', 'feature-test',
        ];

        $this->artisan('mod-make:module', ['mod' => 'Module'])
            ->expectsQuestion('自定义模块内容?(y/n)', 'y')
            ->expectsQuestion('请选择需要创建的模块内容(可多选，使用逗号隔开)', ['model', 'repository', 'request', 'controller', 'service'])
            ->assertExitCode(0);

        $modelFile = $this->app->basePath() . '/app/Modules/Module/Model/Module.php';
        $this->assertFileExists($modelFile);

        $controllerFile = $this->app->basePath() . '/app/Modules/Module/Controller/ModuleController.php';
        $this->assertFileExists($controllerFile);

        $repositoryFile = $this->app->basePath() . '/app/Modules/Module/Repository/ModuleRepository.php';
        $contractFile = $this->app->basePath() . '/app/Modules/Module/Contracts/ModuleRepositoryContract.php';
        $this->assertFileExists($repositoryFile);
        $this->assertFileExists($contractFile);

        $serviceFile = $this->app->basePath() . '/app/Modules/Module/Service/ModuleService.php';
        $this->assertFileExists($serviceFile);

        $serviceProviderFile = $this->app->basePath() . '/app/Modules/Module/ModuleServiceProvider.php';
        $this->assertFileNotExists($serviceProviderFile);

        $routesFile = $this->app->basePath() . '/app/Modules/Module/routes/api.php';
        $this->assertFileNotExists($routesFile);

        $migrationFile = $this->app->basePath() . '/app/Modules/Module/database/migrations/2018_11_21_085722_create_app_modules_table.php';
        $this->assertFileNotExists($migrationFile);

        $factoryFile = $this->app->basePath() . '/app/Modules/Module/database/factories/ModuleFactory.php';
        $this->assertFileNotExists($factoryFile);

        $requestFile = $this->app->basePath() . '/app/Modules/Module/Request/ModuleRequest.php';
        $this->assertFileExists($requestFile);

        $unitTestFile = $this->app->basePath() . '/app/Modules/Module/Test/Unit/ModuleTest.php';
        $this->assertFileNotExists($unitTestFile);

        $featureTestFile = $this->app->basePath() . '/app/Modules/Module/Test/Feature/ModuleTest.php';
        $this->assertFileNotExists($featureTestFile);
    }
}