<?php


namespace App\Service;


use App\Service\Contracts\IpLocationProviderContract;
use Illuminate\Support\Facades\Http;

class ExternalIpLocationProvider implements IpLocationProviderContract
{
    private $token;
    private $host;

    public function __construct($token, $host) {
        $this->token = $token;
        $this->host = $host;
    }

    public function getLocationByIp(string $ip): string
    {
        $response = Http::get($this->host, ['api_token' => $this->token, 'ip' => $ip]);
        $response = $response->json();
        return $response['country'];
    }
}
