<?php

namespace App\Libraries;

use App\Traits\InstanceTrait;

class IpLibrary
{

    use InstanceTrait;

    /**
     * 判断IP是否在某个网段内
     * @param string $ip
     * @param string $network 网段,如:110.86.28.64/29
     * @return bool
     */
    public function inNetwork($ip, $network)
    {
        $networkSegments = explode('/', $network, 2);
        $ipRangeStart = isset($networkSegments[0]) ? ip2long($networkSegments[0]) : 0;
        $ipRangeEnd = isset($networkSegments[1]) ? $ipRangeStart + pow(2, 32 - $networkSegments[1]) - 1 : $ipRangeStart;
        $ip = ip2long($ip);
        return $ip >= $ipRangeStart && $ip <= $ipRangeEnd;
    }

}