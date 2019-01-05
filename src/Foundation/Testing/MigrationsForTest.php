<?php
/**
 * Created by IntelliJ IDEA.
 * User: kiyon
 * Date: 2018/11/14
 * Time: 10:44 AM
 */

namespace Kiyon\Laravel\Foundation\Testing;

use Illuminate\Database\Eloquent\Model as Eloquent;

trait MigrationsForTest
{

    protected function initSchema($tableName, callable $cb)
    {
        $this->schema()->create($tableName, $cb);
    }

    protected function clearSchema($tableNames)
    {
        $tableNames = is_array($tableNames) ? $tableNames : func_get_args();
        foreach ($tableNames as $tableName)
            $this->schema()->drop($tableName);
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
}