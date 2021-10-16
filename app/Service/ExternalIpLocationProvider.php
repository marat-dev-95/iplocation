<?php


namespace App\Service;


use App\Service\Contracts\IpLocationProviderContract;
use Illuminate\Support\Facades\Http;

class ExternalIpLocationProvider implements IpLocationProviderContract
{
    private $host;

    public function __construct($host) {
        $this->host = $host;
    }

    public function getLocationByIp(string $ip): string
    {
        $response = Http::get($this->host.'/'.$ip);
        $response = $response->json();
        return $response['country'];
    }
}
