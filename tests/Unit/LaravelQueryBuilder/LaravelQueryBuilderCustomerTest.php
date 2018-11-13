<?php
/**
 * Created by IntelliJ IDEA.
 * User: kiyon
 * Date: 2018/11/13
 * Time: 11:09 AM
 */

namespace Tests\Unit\LaravelQueryBuilder;


use Illuminate\Database\Schema\Blueprint;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Route;
use Kiyon\Laravel\Foundation\Model\BaseModel;
use Tests\TestCase;
use Illuminate\Database\Eloquent\Model as Eloquent;

class LaravelQueryBuilderCustomerTest extends TestCase
{

    use WithFaker;

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

        $this->setUpFaker();
    }

    /**
     * Tear down the database schema.
     *
     * @return void
     */
    public function tearDown()
    {
        $this->dropSchema();
    }

    /** @test */
    public function 自定义between筛选()
    {
        $resp = $this->getJson('test-query-builder?filter[created_at$><]=2018-11-11,2018-11-16')
            ->json();

        $this->assertCount(2, $resp);
    }

    /** @test */
    public function 自定义notBetween筛选()
    {
        $resp = $this->getJson('test-query-builder?filter[created_at$!><]=2018-11-11,2018-11-16')
            ->json();

        $this->assertCount(0, $resp);
    }

    /** @test */
    public function 自定义数量大小比较筛选()
    {
        $resp = $this->getJson('test-query-builder?filter[count$<]=1')->json();
        $this->assertCount(0, $resp);

        $resp = $this->getJson('test-query-builder?filter[count$<%3d]=12')->json();
        $this->assertCount(1, $resp);

        $resp = $this->getJson('test-query-builder?filter[count$>%3d]=12')->json();
        $this->assertCount(2, $resp);

        $resp = $this->getJson('test-query-builder?filter[count$>]=12')->json();
        $this->assertCount(1, $resp);
    }

    protected function createData()
    {
        TestQueryBuilder::create([
            'name'       => 'tom',
            'uid'        => 123,
            'type'       => 'one',
            'count'      => 12,
            'created_at' => '2018-11-13 09:08:11'
        ]);

        TestQueryBuilder::create([
            'name'       => 'kiyon',
            'uid'        => 12,
            'count'      => 123,
            'type'       => 'two',
            'created_at' => '2018-11-13 09:08:11'
        ]);
    }

    protected function createRoute()
    {
        // GET /test-query-builder?filter[between]=2018-11-11,2018-11-16
        Route::get('test-query-builder', function () {
            $queryBuilders = TestQueryBuilder::filter()
                ->get();

            return response()->json($queryBuilders, 200);
        });
    }

    /**
     * Get a database connection instance.
     *
     * @return \Illuminate\Database\Connection
     */
    protected function connection($connection = 'testing')
    {
        return Eloquent::getConnectionResolver()->connection($connection);
    }

    /**
     * Get a schema builder instance.
     *
     * @return \Illuminate\Database\Schema\Builder
     */
    protected function schema($connection = 'testing')
    {
        return $this->connection($connection)->getSchemaBuilder();
    }

    protected function createSchema()
    {
        $this->schema()->create('test_query_builders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('uid');
            $table->integer('count');
            $table->enum('type', ['one', 'two']);
            $table->timestamps();
        });
    }

    protected function dropSchema()
    {
        $this->schema()->drop('test_query_builders');
    }
}

/**
 * Eloquent Models...
 */
class TestQueryBuilder extends BaseModel
{

    protected $table = 'test_query_builders';
    protected $guarded = [];

    protected $searchable = [
        'created_at',
        'count',
        'type'
    ];

    protected $loadable = [
        'member.name'
    ];
}