<?php

namespace RalfHortt\GeoData\Providers;

use RalfHortt\GeoData\Abstracts\AbstractGeoDataProvider;
use RalfHortt\GeoData\Address;

class OpenStreetMap extends AbstractGeoDataProvider
{
    protected string $endpoint = 'https://nominatim.openstreetmap.org/search?q=%s&format=json&addressdetails=1&limit=1';

    public function request(): Address
    {
        $url = sprintf($this->endpoint, urlencode($this->address->getRequest()));
        $response = $this->sendRequest($url);
        $decodedResponse = \json_decode($response);

        if (json_last_error() != JSON_ERROR_NONE) {
            throw new \Exception('Invalid JSON response:'.$response);
        }

        return $this->address
            ->setResponse($decodedResponse)
            ->setResults($decodedResponse)
            ->setStreet($decodedResponse[0]->address?->road)
            ->setStreetNumber($decodedResponse[0]->address?->house_number)
            ->setPostCode($decodedResponse[0]->address?->postcode)
            ->setCity(isset($decodedResponse[0]->address?->city) ? $decodedResponse[0]->address?->city : $decodedResponse[0]->address?->town)
            ->setCountry($decodedResponse[0]->address?->country)
            ->setLatitude($decodedResponse[0]->lat)
            ->setLongitude($decodedResponse[0]->lon);
    }

    protected function sendRequest(string $url): mixed
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_REFERER, $_SERVER['HTTP_HOST']);
        curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
        $data = curl_exec($ch);
        curl_close($ch);

        return $data;
    }
}
