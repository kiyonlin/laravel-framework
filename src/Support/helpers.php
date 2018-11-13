<?php
if (! function_exists('create')) {

    /**
     * create models in database
     *
     * @return mixed
     */
    function create()
    {
        $arguments = func_get_args();

        if (isset($arguments[1]) && is_string($arguments[1])) {
            return factory($arguments[0])
                ->states($arguments[1])
                ->create($arguments[2] ?? []);
        } elseif (isset($arguments[1]) && is_string($arguments[1])
            && isset($arguments[2]) && is_array($arguments[2])) {
            return factory($arguments[0])
                ->states($arguments[1])
                ->times($arguments[3] ?? null)
                ->create($arguments[2]);
        } elseif (isset($arguments[1]) && is_string($arguments[1])
            && isset($arguments[2]) && is_numeric($arguments[2])) {
            return factory($arguments[0])
                ->states($arguments[1])
                ->times($arguments[2])
                ->create();
        } elseif (isset($arguments[1]) && is_array($arguments[1])) {
            return factory($arguments[0])
                ->times($arguments[2] ?? null)
                ->create($arguments[1]);
        } elseif (isset($arguments[1]) && is_numeric($arguments[1])) {
            return factory($arguments[0])
                ->times($arguments[1] ?? null)
                ->create();
        } else {
            return factory($arguments[0])->create();
        }
    }
}

if (! function_exists('make')) {

    /**
     * make models
     * @return mixed
     */
    function make()
    {
        $arguments = func_get_args();

        if (isset($arguments[1]) && is_string($arguments[1])) {
            return factory($arguments[0])
                ->states($arguments[1])
                ->make($arguments[2] ?? []);
        } elseif (isset($arguments[1]) && is_string($arguments[1])
            && isset($arguments[2]) && is_array($arguments[2])) {
            return factory($arguments[0])
                ->states($arguments[1])
                ->times($arguments[3] ?? null)
                ->make($arguments[2]);
        } elseif (isset($arguments[1]) && is_string($arguments[1])
            && isset($arguments[2]) && is_numeric($arguments[2])) {
            return factory($arguments[0])
                ->states($arguments[1])
                ->times($arguments[2])
                ->make();
        } elseif (isset($arguments[1]) && is_array($arguments[1])) {
            return factory($arguments[0])
                ->times($arguments[2] ?? null)
                ->make($arguments[1]);
        } elseif (isset($arguments[1]) && is_numeric($arguments[1])) {
            return factory($arguments[0])
                ->times($arguments[1] ?? null)
                ->make();
        } else {
            return factory($arguments[0])->make();
        }
    }
}

if (! function_exists('raw')) {

    /**
     * make raw data based on models
     * @return mixed
     */
    function raw()
    {
        $arguments = func_get_args();

        if (isset($arguments[1]) && is_string($arguments[1])) {
            return factory($arguments[0])
                ->states($arguments[1])
                ->raw($arguments[2] ?? []);
        } elseif (isset($arguments[1]) && is_string($arguments[1])
            && isset($arguments[2]) && is_array($arguments[2])) {
            return factory($arguments[0])
                ->states($arguments[1])
                ->times($arguments[3] ?? null)
                ->raw($arguments[2]);
        } elseif (isset($arguments[1]) && is_string($arguments[1])
            && isset($arguments[2]) && is_numeric($arguments[2])) {
            return factory($arguments[0])
                ->states($arguments[1])
                ->times($arguments[2])
                ->raw();
        } elseif (isset($arguments[1]) && is_array($arguments[1])) {
            return factory($arguments[0])
                ->times($arguments[2] ?? null)
                ->raw($arguments[1]);
        } elseif (isset($arguments[1]) && is_numeric($arguments[1])) {
            return factory($arguments[0])
                ->times($arguments[1] ?? null)
                ->raw();
        } else {
            return factory($arguments[0])->raw();
        }
    }
}

if (! function_exists('logcli')) {
    /**
     * Get a log driver instance.
     *
     * @return \Illuminate\Log\LogManager|\Psr\Log\LoggerInterface
     */
    function logcli()
    {
        return app('log')->driver('cli');
    }
}