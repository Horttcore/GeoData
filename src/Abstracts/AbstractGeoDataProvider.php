<?php
namespace RalfHortt\GeoData\Abstracts;

use RalfHortt\GeoData\Address;
use RalfHortt\GeoData\Contracts\GeoDataProviderContract;
use RalfHortt\GeoData\Contracts\GeoDataCacheProviderContract;

abstract class AbstractGeoDataProvider implements GeoDataProviderContract
{
    protected $address;
    protected $cache;

    public function __construct(Address $address, ?GeoDataCacheProviderContract $cache = null)
    {
        $this->address = $address;
        $this->cache = $cache;
    }

    public function get()
    {
        if (!$this->cache) {
            return $this->request($this->address);
        }

        return $this->cache->get($this->address);
    }

    public function request(): void
    {
    }
}
