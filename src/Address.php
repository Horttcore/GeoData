<?php
namespace RalfHortt\GeoData;

use RalfHortt\GeoData\Contracts\GeoDataProviderContract;
use RalfHortt\GeoData\Contracts\GeoDataCacheProviderContract;
use RalfHortt\GeoData\Providers\OpenStreetMap;

class Address
{
    protected $request;
    protected $geoDataProvider;
    protected $geoDataCacheProvider;
    protected $response;

    protected $latitude;
    protected $longitude;
    protected $street;
    protected $streetNumber;
    protected $city;
    protected $postCode;
    protected $country;

    protected $results = 0;
    protected $resultCount = 0;

    public function __construct(string $request, $provider = null, $cache = null)
    {
        $this->request = $request;
        $this->geoDataProvider = $provider ? $provider : new OpenStreetMap($this, $cache);
        $this->geoDataProvider->get();
    }

    public function getResponse(): \stdClass
    {
        return $this->response;
    }

    public function getRequest()
    {
        return $this->request;
    }

    public function getResults()
    {
        return $this->results;
    }

    public function getStreet(): string
    {
        return $this->street;
    }

    public function getStreetNumber(): string
    {
        return $this->streetNumber;
    }

    public function getPostCode(): string
    {
        return $this->postCode;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function getLatitude(): float
    {
        return $this->latitude;
    }

    public function getLongitude(): float
    {
        return $this->longitude;
    }

    public function setResponse($response): void
    {
        $this->response = $response;
    }

    public function setResults($results): void
    {
        $this->results = $results;
        $this->resultCount = count($this->results);
    }

    public function setStreet(string $street): void
    {
        $this->street = $street;
    }

    public function setStreetNumber(string $streetNumber): void
    {
        $this->streetNumber = $streetNumber;
    }

    public function setPostCode(string $postCode): void
    {
        $this->postCode = $postCode;
    }

    public function setCity(string $city): void
    {
        $this->city = $city;
    }

    public function setCountry(string $country): void
    {
        $this->country = $country;
    }

    public function setLatitude(float $latitude): void
    {
        $this->latitude = $latitude;
    }

    public function setLongitude(float $longitude): void
    {
        $this->longitude = $longitude;
    }

    public function distanceTo(Address $address, string $unit = 'KM'): float
    {
        if (($this->getLatitude() == $address->getLatitude()) && ($this->getLongitude() == $address->getLongitude())) {
            return 0;
        }

        $theta = $this->getLongitude() - $address->getLongitude();
        $distance = sin(deg2rad($this->getLatitude())) * sin(deg2rad($address->getLatitude())) +  cos(deg2rad($this->getLatitude())) * cos(deg2rad($address->getLatitude())) * cos(deg2rad($theta));
        $distance = acos($distance);
        $distance = rad2deg($distance);
        $distance = $distance * 60 * 1.1515;
        $unit = strtoupper($unit);

        if ($unit == "KM") {
            $distance = ($distance * 1.609344);
        } elseif ($unit == "NM") {
            $distance = ($distance * 0.8684);
        }

        return $distance;
    }
}
