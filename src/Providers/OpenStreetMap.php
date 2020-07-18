<?php
namespace RalfHortt\GeoData\Providers;

use RalfHortt\GeoData\Address;
use RalfHortt\GeoData\Contracts\GeoDataProviderContract;

class OpenStreetMap // implements GeoDataProviderContract
{
    public function request(Address $address)
    {
        $url = sprintf('https://nominatim.openstreetmap.org/?format=json&addressdetails=1&format=json&q=%s', urlencode($address->getRequest()));
        $response = $this->sendRequest($url);
        $response = \json_decode($response);

        if (json_last_error() != JSON_ERROR_NONE) {
            return;
        }

        $address->setResponse($response);
        $address->setStreet($response[0]->address->road);
        $address->setStreetNumber($response[0]->address->house_number);
        $address->setPostCode($response[0]->address->postcode);
        $address->setCity($response[0]->address->city);
        $address->setCountry($response[0]->address->country);
        $address->setLatitude($response[0]->lat);
        $address->setLongitude($response[0]->lon);
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
