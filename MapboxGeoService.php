<?php


namespace App\Services\Geo;


use GuzzleHttp\Client;
use Psr\Http\Client\ClientInterface;

class MapboxGeoService implements GeoServiceInterface
{

    private string $apiKey;

    private string $apiUrl;

    private ClientInterface $httpClient;

    public function __construct()
    {
        $this->apiKey = config('geocode.api_key');
        $this->apiUrl = config('geocode.api_url');
        $this->httpClient = new Client();
    }

    public function searchByLocation(string $location)
    {
        $url = $this->constructApiUrl($location);
        return $this->searchRequest($url);
    }

    private function constructApiUrl($address)
    {
        $encodedAddress = $this->encodeUrl($address);
        return $this->apiUrl.$encodedAddress.'.json';
    }

    private function encodeUrl($url)
    {
        return rawurlencode($url);
    }

    protected function searchRequest($url, $limit = 5)
    {
        $res = $this->httpClient->get($url, [
            'query' => [
                'access_token' => $this->apiKey, 'autocomplete' => true,
                'limit'        => $limit
            ]
        ]);
        return json_decode($res->getBody()->getContents())->features;
    }

    public function searchByCoords(float $lat, float $lng)
    {
        $location = "$lng,$lat";
        $url = $this->constructApiUrl($location);
        return $this->searchRequest($url, 1);
    }
}
