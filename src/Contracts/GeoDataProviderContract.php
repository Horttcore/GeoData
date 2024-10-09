<?php

namespace RalfHortt\GeoData\Contracts;

use RalfHortt\GeoData\Address;

interface GeoDataProviderContract
{
    public function __construct(Address $address);

    public function get(): Address;

    public function request(): Address;
}
