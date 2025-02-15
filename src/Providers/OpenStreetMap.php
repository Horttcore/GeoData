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
            ->setStreet(isset($decodedResponse[0]) ? $decodedResponse[0]->address?->road : null)
            ->setStreetNumber(isset($decodedResponse[0]) ? $decodedResponse[0]->address?->house_number : null)
            ->setPostCode(isset($decodedResponse[0]) ? $decodedResponse[0]->address?->postcode : null)
            ->setCity(isset($decodedResponse[0]) ? $decodedResponse[0]->address?->city ? isset($decodedResponse[0]) ? $decodedResponse[0]->address?->city : isset($decodedResponse[0]) ? $decodedResponse[0]->address?->town : null)
            ->setCountry(isset($decodedResponse[0]) ? $decodedResponse[0]->address?->country : null)
            ->setLatitude(isset($decodedResponse[0]) ? $decodedResponse[0]->lat : null)
            ->setLongitude(isset($decodedResponse[0]) ? $decodedResponse[0]->lon : null);
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
