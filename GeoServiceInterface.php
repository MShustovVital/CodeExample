<?php


namespace App\Services\Geo;


interface GeoServiceInterface
{

    public function searchByLocation(string $location);

    public function searchByCoords(float $lat, float $lng);

}
