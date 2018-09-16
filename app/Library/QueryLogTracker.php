<?php
/**
 * Created by PhpStorm.
 * User: AZYF
 * Date: 2018/8/14
 * Time: 11:08
 */
namespace App\Library;

use Illuminate\Database\Events\QueryExecuted;
use DateTime;
use DB;

/**
 * 查询日志输出
 *
 * @package app.Listeners
 */
class QueryLogTracker
{
    /**
     * Handle the event.
     *
     * @param QueryExecuted $event
     * @internal param $query
     * @internal param $bindings
     * @internal param $time
     */
    public function handle(QueryExecuted $event)
    {
        $time = $event->time;
        $bindings = $event->bindings;
        foreach ($bindings as $i => $binding) {
            if ($binding instanceof DateTime) {
                $bindings[$i] = $binding->format('\'Y-m-d H:i:s\'');
            } else if (is_string($binding)) {
                $bindings[$i] = DB::getPdo()->quote($binding);
            } else if (null === $binding) {
                $bindings[$i] = 'null';
            }
        }
        $query = str_replace(array('%', '?', "\r", "\n", "\t"), array('%%', '%s', ' ', ' ', ' '), $event->sql);
        $query = preg_replace('/\s+/uD', ' ', $query);
        $query = vsprintf($query, $bindings) . ';';

        app('sql-log')->debug($query, compact('time'));
    }
}
