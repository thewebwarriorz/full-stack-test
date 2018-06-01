<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ServersStatistic extends Model
{
    /**
     * Get all statistic by server id
     *
     * @param int $serverId
     * @return array
     */
    public static function getStatisticSummaryById(int $serverId)
    {

        // Get all servers statistic
        return ServersStatistic::select(
            array(
                DB::raw("AVG(`servers_statistics_value`) as average"),
                DB::raw("MIN(`servers_statistics_value`) as min"),
                DB::raw("MAX(`servers_statistics_value`) as max")
            )
        )
            ->where('servers_statistics_server_id', '=', $serverId)
            ->get()
            ->toArray();

    }

    /**
     * Get the selected server statistic
     *
     * @param int $serverId
     * @return mixed
     */
    public static function getStatisticById(int $serverId)
    {

        // Get one server statistic
        return ServersStatistic::select('servers_statistics_value')
            ->where('servers_statistics_server_id', $serverId)
            ->get()
            ->toArray();

    }
}
