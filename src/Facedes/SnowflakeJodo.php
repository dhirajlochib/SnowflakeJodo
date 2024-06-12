<?php 

namespace Vendor\Rdr\Snowflakejodo\Src\Facedes;

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