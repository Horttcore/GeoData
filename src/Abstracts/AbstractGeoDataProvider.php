<?php

namespace RalfHortt\GeoData\Abstracts;

use RalfHortt\GeoData\Address;
use RalfHortt\GeoData\Contracts\GeoDataCacheProviderContract;
use RalfHortt\GeoData\Contracts\GeoDataProviderContract;

abstract class AbstractGeoDataProvider implements GeoDataProviderContract
{
    protected Address $address;

    protected ?GeoDataCacheProviderContract $cache;

    public function __construct(Address $address)
    {
        $this->address = $address;
        $this->cache = $this->address->getCacheProvider();
    }

    public function get(): Address
    {
        if (! $this->cache) {
            return $this->request($this->address);
        }

        return $this->cache->get($this->address);
    }

    abstract public function request(): Address;
}
