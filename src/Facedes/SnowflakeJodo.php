<?php 

namespace Rdr\SnowflakeJodo\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static mixed query(string $query, array $bindings = [])
 */
class SnowflakeJodo extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'snowflakejodo'; 
    }
}