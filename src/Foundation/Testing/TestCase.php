<?php
/**
 * Created by IntelliJ IDEA.
 * User: kiyon
 * Date: 2018/11/21
 * Time: 10:13 AM
 */

namespace Kiyon\Laravel\Foundation\Testing;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Kiyon\Laravel\Authentication\Model\User;

abstract class TestCase extends BaseTestCase
{

    use RefreshDatabase, CreatesApplication, WithMock, WithFaker;

    protected function setUp()
    {
        parent::setUp();

        $this->withoutExceptionHandling();
    }

    /**
     * 登录用户
     *
     * @param User|null $user
     * @return $this
     */
    protected function signIn(User $user = null)
    {
        $user = $user ?: create(User::class);

        auth()->login($user);

        return $this;
    }

    /**
     * 登录用户
     *
     * @return $this
     */
    protected function signInSystemAdmin()
    {
        return $this->signIn(createSystemAdmin());
    }

    /**
     * 从日志获取回调执行后发送的通知的内容
     *
     * @param callable $cb
     * @return string
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function getNotifyContentFromLog(callable $cb)
    {
        config(['mail.driver' => 'log']);

        Log::useFiles(storage_path('logs/test.log'));

        $cb && $cb();

        // 执行后查看日志是否记录发送了邮件和短信
        $content = Storage::disk('logs')->get('test.log');

        Storage::disk('logs')->delete('test.log');

        return $content;
    }

    /**
     * 从日志获取任务执行中response的内容
     *
     * @param callable $cb
     * @return string
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function getResponseContentFromLog(callable $cb)
    {
        // 临时添加job日志输出到指定文件
        config(['myams.run_log_report.cli.LOCAL_FILE.list.999' => 'storage/logs/test']);

        $cb && $cb();

        $content = Storage::disk('logs')->get('test');

        Storage::disk('logs')->delete('test');

        return $content;
    }

    /**
     * 断言辅助，判断验证结果是否包含错误
     *
     * @param array $resp
     * @param string $key
     * @return void
     */
    protected function assertErrorsHas($resp, $key)
    {
        $this->assertArrayHasKey($key, array_get($resp, "errors", []), "{$key} field does not in errors.");
    }
}
