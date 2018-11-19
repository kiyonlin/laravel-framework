<?php
/**
 * Created by IntelliJ IDEA.
 * User: kiyon
 * Date: 2018/11/14
 * Time: 8:22 AM
 */

namespace Tests\Unit\GlobalScopes;


use Illuminate\Database\Schema\Blueprint;
use Kiyon\Laravel\Authentication\Model\User;
use Kiyon\Laravel\Authorization\Model\Role;
use Kiyon\Laravel\Foundation\Model\BaseModel;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Kiyon\Laravel\Support\Constant;
use Tests\MigrationsForTest;
use Tests\TestCase;

class MemberScope extends TestCase
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
    public function 没有认证用户时，不附加uid筛选条件()
    {
        $this->assertNull(auth()->user());

        $sql = MemberModel::where('created_at', '>', now())->toSql();
        $this->assertEquals('select * from "member" where "created_at" > ?', $sql);

        $sql = NonMemberModel::where('created_at', '>', now())->toSql();
        $this->assertEquals('select * from "non_member" where "created_at" > ?', $sql);
    }

    /** @test */
    public function 有认证用户时，非member角色不附加uid筛选条件()
    {
        $this->signIn();

        $this->assertInstanceOf(User::class, auth()->user());

        $sql = MemberModel::where('created_at', '>', now())->toSql();
        $this->assertEquals('select * from "member" where "created_at" > ?', $sql);

        $sql = NonMemberModel::where('created_at', '>', now())->toSql();
        $this->assertEquals('select * from "non_member" where "created_at" > ?', $sql);
    }

    /** @test */
    public function 会员用户登录时，有uid字段的记录才会添加uid筛选条件()
    {
        $user = getMember();

        $this->signIn($user);

        $this->assertTrue($user->isMember());

        $sql = MemberModel::where('created_at', '>', now())->toSql();
        $this->assertEquals('select * from "member" where "created_at" > ? and "uid" = ?', $sql);

        $sql = NonMemberModel::where('created_at', '>', now())->toSql();
        $this->assertEquals('select * from "non_member" where "created_at" > ?', $sql);
    }

    protected function createSchema()
    {
        $this->initSchema('member', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('uid');
            $table->timestamps();
        });

        $this->initSchema('non_member', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('count');
            $table->timestamps();
        });
    }

    protected function dropSchema()
    {
        $this->clearSchema('member', 'non_member');
    }
}

class MemberModel extends BaseModel
{

    protected $table = 'member';

    protected $fillable = ['uid'];
}

class NonMemberModel extends BaseModel
{

    protected $table = 'non_member';

    protected $fillable = ['count'];
}