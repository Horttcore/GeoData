<?php
namespace RalfHortt\GeoData\Contracts;

use RalfHortt\GeoData\Address;

abstract class GeoDataProviderContract
{
    abstract public function request(Address $address): void;
}
