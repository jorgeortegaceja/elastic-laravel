<?php
namespace Elastic;

use Illuminate\Support\Facades\Http;

class Client extends Http
{

    private $uri = 'https://127.0.0.1:9243';

    /**
     * Constructs a new Client instance.
     *
     * This is the preferred class for connecting to a Elastic Search server or
     * cluster of servers. It serves as a gateway for accessing individual
     * databases and collections.
     *
     */
    public function __construct(
        $url,
        array $uriOptions = [],
        array $driverOptions = []
    ) {

        $this->validateConnection($url);
    }

    private function validateConnection(string $url)
    {

    }
}
