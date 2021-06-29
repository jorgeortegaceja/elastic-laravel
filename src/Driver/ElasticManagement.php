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

    public function execute($query, $options = [])
    {

        try {

            $response =
            Http::withBasicAuth(
                $this->credentials['username'], $this->credentials['password']
            )
                ->{strtolower($query->method)}("https://{$this->dsn}/$query->entity");

            return $response->body();
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

}
