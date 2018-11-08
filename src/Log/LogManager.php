<?php
/**
 * Created by IntelliJ IDEA.
 * User: kiyon
 * Date: 2018/11/8
 * Time: 3:06 PM
 */

namespace Kiyon\Laravel\Log;

use Illuminate\Log\LogManager as LaravelLogManager;

class LogManager extends LaravelLogManager
{

    /**
     * log a line with '-'
     *
     * @param string $symbol
     * @param int $length
     * @param string $level
     */
    public function line($symbol = '-', $length = 20, $level = 'info')
    {
        $this->info(str_repeat($symbol, $length));
    }

    /**
     * log a line with '='
     *
     * @param string $symbol
     * @param int $length
     * @param string $level
     */
    public function doubleLine($symbol = '=', $length = 20, $level = 'info')
    {
        $this->line($symbol, $length, $level);
    }
}