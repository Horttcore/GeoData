<?php
namespace RalfHortt\GeoData\Providers;

use RalfHortt\GeoData\Address;
use RalfHortt\GeoData\Abstracts\AbstractGeoDataProvider;

class OpenStreetMap extends AbstractGeoDataProvider
{
    public function request(): void
    {
        $url = sprintf('https://nominatim.openstreetmap.org/?format=json&addressdetails=1&format=json&q=%s', urlencode($this->address->getRequest()));
        $response = $this->sendRequest($url);
        $response = \json_decode($response);

        if (json_last_error() != JSON_ERROR_NONE) {
            return;
        }

        $this->address->setResponse($response);
        $this->address->setResults($response);

        if (isset($response[0]->address->road)) {
            $this->address->setStreet($response[0]->address->road);
        }
        if (isset($response[0]->address->house_number)) {
            $this->address->setStreetNumber($response[0]->address->house_number);
        }
        if (isset($response[0]->address->postcode)) {
            $this->address->setPostCode($response[0]->address->postcode);
        }
        if (isset($response[0]->address->city)) {
            $this->address->setCity($response[0]->address->city);
        }
        if (isset($response[0]->address->country)) {
            $this->address->setCountry($response[0]->address->country);
        }
        if (isset($response[0]->lat)) {
            $this->address->setLatitude($response[0]->lat);
        }
        if (isset($response[0]->lon)) {
            $this->address->setLongitude($response[0]->lon);
        }
    }

    protected function sendRequest(string $url)
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
