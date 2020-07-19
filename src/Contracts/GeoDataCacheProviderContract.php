<?php
namespace RalfHortt\GeoData\Contracts;

use RalfHortt\GeoData\Address;

interface GeoDataCacheProviderContract
{
    abstract public function get(Address $address): void;
}
