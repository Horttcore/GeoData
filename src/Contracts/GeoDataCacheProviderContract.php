<?php

namespace RalfHortt\GeoData\Contracts;

use RalfHortt\GeoData\Address;

interface GeoDataCacheProviderContract
{
    public function get(Address $address): Address;
}
