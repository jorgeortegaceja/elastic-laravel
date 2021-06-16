<?php
namespace Elastic\Driver;

use Illuminate\Support\Facades\Http;

class Client
{

    private $manager;

    private $readConcern;

    private $readPreference;

    private $uri = 'https://127.0.0.1:9243';

    private $credentials = [];

    private $driverOptions = [];

    private $index = '';

    /**
     * Constructs a new Client instance.
     *
     * This is the preferred class for connecting to a Elastic Search server or
     * cluster of servers. It serves as a gateway for accessing individual
     * databases and collections.
     *
     */
    public function __construct(
        string $uri,
        array $credentials = [],
        array $driverOptions = []
    ) {
        $this->uri = $uri;
        $this->credentials = $credentials;
        $this->driverOptions = $driverOptions;
        $this->validateConnection();
    }

    private function validateConnection()
    {
        $response = Http::withBasicAuth(
            $this->credentials['username'],
            $this->credentials['password']
        )->get($this->uri);

        return $response->successful();
    }

    public function selectIndex($default_index)
    {
        $this->index = $default_index;

        return new Database($this->manager, $default_index, []);
    }

}
