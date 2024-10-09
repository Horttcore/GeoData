<?php

namespace RalfHortt\GeoData;

use RalfHortt\GeoData\Contracts\GeoDataCacheProviderContract;
use RalfHortt\GeoData\Contracts\GeoDataProviderContract;
use RalfHortt\GeoData\Providers\OpenStreetMap;

class Address
{
    private array $response = [];

    private array $results = [];

    private ?float $latitude = null;

    private ?float $longitude = null;

    private ?string $street = null;

    private ?string $streetNumber = null;

    private ?string $city = null;

    private ?string $postCode = null;

    private ?string $country = null;

    public function __construct(
        private string $request,
        private ?GeoDataProviderContract $geoDataProvider = null,
        private ?GeoDataCacheProviderContract $geoDataCacheProvider = null
    ) {
        $this->geoDataProvider = $geoDataProvider ? new $this->$geoDataProvider($this) : new OpenStreetMap($this);
        $this->geoDataProvider->get();
    }

    public function getCacheProvider(): ?GeoDataCacheProviderContract
    {
        return $this->geoDataCacheProvider;
    }

    public function getResponse(): array
    {
        return $this->response;
    }

    public function getRequest(): string
    {
        return $this->request;
    }

    public function getResults(): array
    {
        return $this->results;
    }

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function getStreetNumber(): ?string
    {
        return $this->streetNumber;
    }

    public function getPostCode(): ?string
    {
        return $this->postCode;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setResponse(array $response): self
    {
        $this->response = $response;

        return $this;
    }

    public function setResults(array $results = []): self
    {
        $this->results = $results;

        return $this;
    }

    public function setStreet(?string $street): self
    {
        $this->street = $street;

        return $this;
    }

    public function setStreetNumber(?string $streetNumber): self
    {
        $this->streetNumber = $streetNumber;

        return $this;
    }

    public function setPostCode(?string $postCode): self
    {
        $this->postCode = $postCode;

        return $this;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function setCountry(?string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function setLatitude(?float $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function setLongitude(?float $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function distanceTo(Address $address, string $unit = 'KM'): ?float
    {
        $lat1 = $this->getLatitude();
        $lon1 = $this->getLongitude();
        $lat2 = $address->getLatitude();
        $lon2 = $address->getLongitude();

        if ($lat1 === $lat2 && $lon1 === $lon2) {
            return 0;
        }

        $theta = $lon1 - $lon2;
        $distance = sin(deg2rad($lat1)) * sin(deg2rad($lat2))
            + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $distance = rad2deg(acos($distance)) * 60 * 1.1515;

        return match (strtoupper($unit)) {
            'KM' => $distance * 1.609344,
            'NM' => $distance * 0.8684,
            default => $distance,
        };
    }
}
