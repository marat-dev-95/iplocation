<?php

namespace App\Http\Controllers;

use App\Http\Requests\IpLocationStoreRequest;
use App\Http\Resources\IpLocationResource;
use App\Models\IpLocation;
use App\Service\Contracts\IpLocationProviderContract;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;

class IpLocationController extends Controller
{

    private $ipLocationProvider;

    public function __construct(IpLocationProviderContract $ipLocationProvider)
    {
        $this->ipLocationProvider = $ipLocationProvider;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(IpLocationStoreRequest $request)
    {
        $ipLocations = $request->ip_locations;
        $savedLocations = collect();

        foreach($ipLocations as $ipLocation) {
            $newIpLocation = IpLocation::create(['country_name'=>$ipLocation['country_name'], 'ip_address' => $ipLocation['ip']]);
            $savedLocations->push($newIpLocation);
        }

        return IpLocationResource::collection($savedLocations);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        if($request->has('ip_addresses')) {
            $ipAddresses = $request->ip_addresses;
            $ipLocations = IpLocation::whereIn('ip_address', $ipAddresses)->get();
            $notFoundedIpLocations = array_diff($ipAddresses, $ipLocations->pluck('ip_address')->toArray());

            if(!empty($notFoundedIpLocations)) {
                foreach ($notFoundedIpLocations as $ip) {
                    $country = $this->ipLocationProvider->getLocationByIp($ip);
                    $newIpLocation = IpLocation::create(['country_name'=>$country, 'ip_address'=>$ip]);
                    $ipLocations->push($newIpLocation);
                }
            }

            return IpLocationResource::collection($ipLocations);
        } else {
            return IpLocationResource::collection(IpLocation::all());
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(IpLocationStoreRequest $request)
    {
        $ipLocations = $request->ip_locations;

        foreach($ipLocations as $ipLocation) {
            IpLocation::where('ip_address', $ipLocation['ip'])
                ->update(['country_name' => $ipLocation['country_name']]);
        }
        $ipLocationsCollection = IpLocation::whereIn('ip_address', Arr::pluck($ipLocations, 'ip'))->get();

        return IpLocationResource::collection($ipLocationsCollection);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $ipAddresses = $request->ip_addresses;
        IpLocation::whereIn('ip_address', $ipAddresses)->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function getLocation(Request $request) {
        $ipAddress = $request->ip_address;

        $ipLocation = IpLocation::where(['ip_address'=>$ipAddress])->first();

        if(empty($ipLocation)) {
            /**
             * @var $externalProvider IpLocationProviderContract
             */
            $externalProvider = app(IpLocationProviderContract::class);

            $ipLocation = IpLocation::create([
                'ip_address' => $ipAddress,
                'country_name' => $externalProvider->getLocationByIp($ipAddress)
            ]);
        }

        return new IpLocationResource($ipLocation);
    }
}
