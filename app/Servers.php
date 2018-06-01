<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Servers extends Model
{
    /**
     * Get the statistic for the servers.
     */
    public function statistic()
    {
        return $this->hasMany('App\ServersStatistic');
    }
}
