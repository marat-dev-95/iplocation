<?php


namespace App\Service\Contracts;


interface IpLocationProviderContract
{
    public function getLocationByIp(string $ip):string;
}
