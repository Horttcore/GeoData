<?php
namespace RalfHortt\GeoData\Contracts;

use RalfHortt\GeoData\Address;
use RalfHortt\GeoData\Contracts\GeoDataCacheProviderContract;

interface GeoDataProviderContract
{
    public function __construct(Address $address, GeoDataCacheProviderContract $cache);
    public function get();
    public function request(): void;
}
