<?php
/**
 * Created by IntelliJ IDEA.
 * User: kiyon
 * Date: 2018/11/13
 * Time: 11:09 AM
 */

namespace Tests\Unit\LaravelQueryBuilder;


use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Route;
use Kiyon\Laravel\Contracts\Repository\RestfulRepositoryContract;
use Kiyon\Laravel\Foundation\Model\BaseModel;
use Kiyon\Laravel\Foundation\Repository\RestfulRepository;
use Kiyon\Laravel\Foundation\Routing\Controller;
use Tests\MigrationsForTest;
use Tests\TestCase;

class LaravelQueryBuilderCustomerTest extends TestCase
{

    use MigrationsForTest;

    /**
     * Setup the database schema.
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $this->createSchema();

        $this->createData();

        $this->createRoute();
    }

    /**
     * Tear down the database schema.
     *
     * @return void
     */
    public function tearDown()
    {
        parent::tearDown();

        $this->dropSchema();
    }

    /** @test */
    public function 自定义between筛选()
    {
        $resp = $this->getJson('test-query-builder?search[created_at$><]=2018-11-11,2018-11-16')
            ->json();

        $this->assertCount(2, $resp);
    }

    /** @test */
    public function 自定义notBetween筛选()
    {
        $resp = $this->getJson('test-query-builder?search[created_at$!><]=2018-11-11,2018-11-16')
            ->json();

        $this->assertCount(0, $resp);
    }

    /** @test */
    public function 自定义数量大小比较筛选()
    {
        $resp = $this->getJson('test-query-builder?search[count$<]=1')->json();
        $this->assertCount(0, $resp);

        $resp = $this->getJson('test-query-builder?search[count$<%3d]=12')->json();
        $this->assertCount(1, $resp);

        $resp = $this->getJson('test-query-builder?search[count$>%3d]=12')->json();
        $this->assertCount(2, $resp);

        $resp = $this->getJson('test-query-builder?search[count$>]=12')->json();
        $this->assertCount(1, $resp);
    }

    /** @test */
    public function bool值筛选()
    {
        $resp = $this->getJson('test-query-builder?search[admin]=0')->json();
        $this->assertCount(1, $resp);

        $resp = $this->getJson('test-query-builder?search[admin]=1')->json();
        $this->assertCount(1, $resp);
    }

    /** @test */
    public function 数组值筛选()
    {
        $resp = $this->getJson('test-query-builder?search[type]=one')->json();
        $this->assertCount(1, $resp);

        $resp = $this->getJson('test-query-builder?search[type]=two')->json();
        $this->assertCount(1, $resp);

        $resp = $this->getJson('test-query-builder?search[type]=one,two')->json();
        $this->assertCount(2, $resp);
    }

    /** @test */
    public function 测试排序()
    {
        $resp = $this->getJson('test-query-builder?sort=name')->json();
        $this->assertEquals(['kiyon', 'tom'], [$resp[0]['name'], $resp[1]['name']]);

        $resp = $this->getJson('test-query-builder?sort=-name')->json();
        $this->assertEquals(['tom', 'kiyon'], [$resp[0]['name'], $resp[1]['name']]);
    }

    /** @test */
    public function 根据page和perPage参数进行分页控制()
    {
        $resp = $this->getJson('test-query-builder?page=1&perPage=15')->json();
        $this->assertEquals(1, $resp['current_page']);
        $this->assertEquals(2, $resp['total']);
        $this->assertArrayHasKey('data', $resp);
    }

    protected function createData()
    {
        TestQueryBuilder::create([
            'name'       => 'tom',
            'uid'        => 123,
            'type'       => 'one',
            'count'      => 12,
            'admin'      => true,
            'created_at' => '2018-11-13 09:08:11'
        ]);

        TestQueryBuilder::create([
            'name'       => 'kiyon',
            'uid'        => 12,
            'count'      => 123,
            'type'       => 'two',
            'admin'      => false,
            'created_at' => '2018-11-13 09:08:11'
        ]);
    }

    protected function createRoute()
    {
        // GET /test-query-builder?filter[between]=2018-11-11,2018-11-16
        Route::get('test-query-builder', '\Tests\Unit\LaravelQueryBuilder\TestQueryBuilderController@index');
    }

    protected function createSchema()
    {
        $this->initSchema('test_query_builders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('uid');
            $table->integer('count');
            $table->enum('type', ['one', 'two']);
            $table->boolean('admin');
            $table->timestamps();
        });
    }

    protected function dropSchema()
    {
        $this->clearSchema('test_query_builders');
    }
}

/**
 * Eloquent Models...
 */
class TestQueryBuilder extends BaseModel
{

    protected $table = 'test_query_builders';
    protected $guarded = [];
    protected $casts = ['admin' => 'boolean'];

    protected $searchable = [
        'created_at',
        'count',
        'type',
        'admin'
    ];

    protected $sortable = ['name'];

    protected $loadable = [
        'member.name'
    ];
}

class TestQueryBuilderController extends Controller
{

    /** @var TestQueryBuilderService */
    protected $service;

    public function __construct(TestQueryBuilderService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $data = request()->all();

        $queryBuilder = $this->service->repo->all($data);

        return $this->respond($queryBuilder);
    }
}

interface TestQueryBuilderRepositoryContract extends RestfulRepositoryContract
{

}

class TestQueryBuilderRepository implements TestQueryBuilderRepositoryContract
{

    use RestfulRepository;

    protected $model;

    public function __construct(TestQueryBuilder $model)
    {
        $this->model = $model;
    }
}

class TestQueryBuilderService
{

    public $repo;

    public function __construct(TestQueryBuilderRepository $repository)
    {
        $this->repo = $repository;
    }
}