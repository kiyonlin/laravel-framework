<?php
/**
 * Created by IntelliJ IDEA.
 * User: kiyon
 * Date: 2018/11/26
 * Time: 8:45 AM
 */

namespace Tests\Feature\Foundation\Middleware;


use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Kiyon\Laravel\Foundation\Middleware\StoreUploadedFile;
use Tests\TestCase;

class StoreUploadedFileTest extends TestCase
{

    /** @test */
    public function 请求中有文件时，根据disk参数保存该文件并返回路径()
    {
        $disk = 'fake';
        Storage::fake($disk);

        $file = UploadedFile::fake()->image('test.jpg');
        $path = $disk . DIRECTORY_SEPARATOR . $file->hashName();

        $this->app['config']->set('filesystems.disks.' . $disk, [
            'driver' => 'local',
            'root'   => storage_path($disk),
        ]);

        Route::middleware(StoreUploadedFile::class . ':' . $disk)->post('foo', function (Request $request) use ($path) {
            $this->assertCount(0, $request->files->all());
            $this->assertEquals($path, $request['file_path']);

            return 'hit';
        });

        $resp = $this->postJson('foo', ['file' => $file])->content();

        $this->assertEquals('hit', $resp);

        Storage::disk($disk)->assertExists($path);
    }
}