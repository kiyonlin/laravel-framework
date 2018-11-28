<?php
/**
 * Created by IntelliJ IDEA.
 * User: kiyon
 * Date: 2018/11/26
 * Time: 8:39 AM
 */

namespace Kiyon\Laravel\Foundation\Middleware;

use Closure;

class StoreUploadedFile
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param  string $disk
     * @return mixed
     */
    public function handle($request, Closure $next, $disk)
    {
        $this->addFileToPath($request, $disk);

        return $next($request);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param string $disk
     */
    protected function addFileToPath($request, $disk)
    {
        $added = [];

        foreach ($request->allFiles() as $key => $file) {
            if ($file->isValid()) {
                $path = $file->store($disk, $disk);
                $added[$key . '_path'] = $path;
            }
        }
        $request->files->replace([]);
        $request->merge($added);
    }
}