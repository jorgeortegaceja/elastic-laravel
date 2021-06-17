<?php

namespace Elastic\Driver;

use Illuminate\Support\Facades\Http;

class ElasticManagement
{
    protected $dsn;
    protected $credentials;
    protected $driverOptions;

    public function __construct(string $dsn, array $credentials, array $driverOptions = [])
    {
        $this->dsn = $dsn;
        $this->credentials = $credentials;
        $this->driverOptions = $driverOptions;
    }

    public function execute($options, $query)
    {
        try {
            $response = Http::withBasicAuth($this->credentials['username'], $this->credentials['password'])
                ->{$query->method}("{$this->dsn}/$query->entity");
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

}
