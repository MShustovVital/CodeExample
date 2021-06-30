<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\Map\AddressRequest;
use App\Http\Requests\Api\Map\CoordsRequest;
use App\Services\Geo\GeoServiceInterface;
use GuzzleHttp\Exception\ClientException;

class MapController extends BaseController
{
    private GeoServiceInterface $geoService;

    public function __construct(GeoServiceInterface $geoService)
    {
        $this->geoService = $geoService;
    }

    /**
     * @OA\Get(
     *      path="/map/locations",
     *      operationId="Search by location",
     *      summary="Get all locations by text",
     *      description="Get all locations by text, see more : https://docs.mapbox.com/api/search/geocoding/#geocoding-response-object",
     *      tags={"Map"},
     *      @OA\Parameter(name="location",required=true, in="query",description="Name of desired location", @OA\Schema(type="string")),
     *      @OA\Parameter(name="access_token",required=true, in="query",description="Key for map access token", @OA\Schema(type="string")),
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", example="True"),
     *              @OA\Property(property="data", type="object",
     *
     *              @OA\Property(property="locations", type="array", @OA\Items(
     *
     *                    @OA\Property(property="id", type="integer"),
     *                    @OA\Property(property="type", type="string",description="Feature , a GeoJSON type from the GeoJSON specification."),
     *                    @OA\Property(property="relevance", type="integer",description="Indicates how well the returned feature matches
     *                          the user's query on a scale from 0 to 1."),
     *                    @OA\Property(property="properties", type="object", description="A point accuracy metric for the returned address feature.",
     *                  @OA\Property(property="accuracy",example="point", type="string"),
     *              ),
     *
     *              @OA\Property(property="text", type="string",description="A string representing the feature in the requested language, if specified."),
     *              @OA\Property(property="place_name", type="string",description="A string representing the feature in the requested language, if specified, and its full result hierarchy."),
     *              @OA\Property(property="center", type="array",description="The coordinates of the feature’s center in the form [longitude,latitude].",@OA\Items(
     *
     *
     *              )),
     *
     *              @OA\Property(property="geometry", type="object", description="An object describing the spatial geometry of the returned feature.",
     *                  @OA\Property(property="type",example="point", type="string"),
     *                  @OA\Property(property="coordinates", type="array",description="The coordinates of the feature’s center in the form [longitude,latitude].",@OA\Items()),
     *              ),
     *
     *              @OA\Property(property="address", type="string",description="A string of the house number for the returned address feature"),
     *
     *              @OA\Property(property="context", type="array",description="An array representing the hierarchy of encompassing parent features. Each parent feature may include any of the above properties.",@OA\Items(
     *
     *                  @OA\Property(property="id",example="region.3290978600358810", type="string"),
     *                  @OA\Property(property="short_code",example="US-IL", type="string"),
     *                  @OA\Property(property="wikidata",example="Q1204", type="string"),
     *                  @OA\Property(property="text",example="Illinois", type="string"),
     *              )),
     *
     *          )),
     *       ),
     *     ),
     *  ),
     * ),
     *
     */
    public function searchByLocation(AddressRequest $request)
    {
        try {
            $res = $this->geoService->searchByLocation($request->location);
            return $this->sendResponse(['locations' => $res]);
        }
        catch (ClientException $e){
            return $this->sendError('Forbidden',403);
        }
    }

    /**
     * @OA\Get(
     *      path="/map/coords",
     *      operationId="Search by coords",
     *      summary="Get all locations by coords",
     *      description="Get all locations by coords, see more : https://docs.mapbox.com/api/search/geocoding/#geocoding-response-object",
     *      tags={"Map"},
     *      @OA\Parameter(name="lat",required=true, in="query",description="Latitude", @OA\Schema(type="numeric")),
     *      @OA\Parameter(name="lng",required=true, in="query",description="Longtitude", @OA\Schema(type="numeric")),
     *      @OA\Parameter(name="access_token",required=true, in="query",description="Key for map access token", @OA\Schema(type="string")),
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", example="True"),
     *              @OA\Property(property="data", type="object",
     *
     *              @OA\Property(property="locations", type="array", @OA\Items(
     *
     *                    @OA\Property(property="id", type="integer"),
     *                    @OA\Property(property="type", type="string",description="Feature , a GeoJSON type from the GeoJSON specification."),
     *                    @OA\Property(property="relevance", type="integer",description="Indicates how well the returned feature matches
     *                          the user's query on a scale from 0 to 1."),
     *                    @OA\Property(property="properties", type="object", description="A point accuracy metric for the returned address feature.",
     *                  @OA\Property(property="accuracy",example="point", type="string"),
     *              ),
     *
     *              @OA\Property(property="text", type="string",description="A string representing the feature in the requested language, if specified."),
     *              @OA\Property(property="place_name", type="string",description="A string representing the feature in the requested language, if specified, and its full result hierarchy."),
     *              @OA\Property(property="center", type="array",description="The coordinates of the feature’s center in the form [longitude,latitude].",@OA\Items(
     *
     *
     *              )),
     *
     *              @OA\Property(property="geometry", type="object", description="An object describing the spatial geometry of the returned feature.",
     *                  @OA\Property(property="type",example="point", type="string"),
     *                  @OA\Property(property="coordinates", type="array",description="The coordinates of the feature’s center in the form [longitude,latitude].",@OA\Items()),
     *              ),
     *
     *              @OA\Property(property="address", type="string",description="A string of the house number for the returned address feature"),
     *
     *              @OA\Property(property="context", type="array",description="An array representing the hierarchy of encompassing parent features. Each parent feature may include any of the above properties.",@OA\Items(
     *
     *                  @OA\Property(property="id",example="region.3290978600358810", type="string"),
     *                  @OA\Property(property="short_code",example="US-IL", type="string"),
     *                  @OA\Property(property="wikidata",example="Q1204", type="string"),
     *                  @OA\Property(property="text",example="Illinois", type="string"),
     *              )),
     *
     *          )),
     *       ),
     *     ),
     *  ),
     * ),
     *
     */
    public function searchByCoords(CoordsRequest $request)
    {
        $res = $this->geoService->searchByCoords($request->lat, $request->lng);
        return $this->sendResponse(['location' => $res]);
    }
}
