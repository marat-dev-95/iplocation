<?php

namespace App\Http\Controllers;

use App\Http\Requests\IpLocationStoreRequest;
use App\Http\Resources\IpLocationResource;
use App\Models\IpLocation;
use App\Service\Contracts\IpLocationProviderContract;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class IpLocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return IpLocationResource::collection(IpLocation::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(IpLocationStoreRequest $request)
    {
        $ipLocation = IpLocation::create($request->validated());

        return new IpLocationResource($ipLocation);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $ipLocation = IpLocation::find($id);

        if(empty($ipLocation))
            return response(['message'=>'not found'], 404);

        return new IpLocationResource($ipLocation);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(IpLocationStoreRequest $request, $id)
    {
        $ipLocation = IpLocation::find($id);
        if(empty($ipLocation))
            return respose(['message'=>'bad request'], Response::HTTP_BAD_REQUEST);

        $ipLocation->update($request->validated());

        return new IpLocationResource($ipLocation);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ipLocation = IpLocation::find($id);
        if($ipLocation)
            $ipLocation->delete();

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
