<?php

namespace Elastic\Driver;

use Elastic\Driver\ElasticManagement;
use Illuminate\Database\Connection as BaseConnection;
use Illuminate\Support\Arr;
use InvalidArgumentException;

class Connection extends BaseConnection
{

    use MethodsTry;

    protected $config;
    protected $db;
    /**
     * The MongoDB connection handler.
     * @var \MongoDB\Client
     */
    protected $connection;

    /**
     * Create a new database connection instance.
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;

        // Build the connection string
        $dns = $this->getDns($config);

        // You can pass options directly to the MongoDB constructor
        $options = Arr::get($config, 'options', []);

        // Create the connection
        $this->connection = $this->createConnection($dns, $config, $options);

        $this->db = $this;
        // Get default database name
        $default_db = $this->getDefaultDatabaseName($dns, $config);

        $this->useDefaultPostProcessor();

        $this->useDefaultSchemaGrammar();

        $this->useDefaultQueryGrammar();

    }

    /**
     * Get the name of the default database based on db config or try to detect it from Dns.
     * @param string $Dns
     * @param array $config
     * @return string
     * @throws InvalidArgumentException
     */
    protected function getDefaultDatabaseName($dns, $config)
    {
        if (empty($config['database'])) {
            if (preg_match('/^elastic(?:[+]srv)?:\\/\\/.+\\/([^?&]+)/s', $dns, $matches)) {
                $config['database'] = $matches[1];
            } else {
                throw new InvalidArgumentException('Database is not properly configured.');
            }
        }
        $this->config["dns"] = $config['database'];
        return $config['database'];
    }

    /**
     * Create a new MongoDB connection.
     * @param string $Dns
     * @param array $config
     * @param array $options
     * @return \MongoDB\Client
     */
    protected function createConnection($dns, array $config, array $options)
    {
        // By default driver options is an empty array.
        $driverOptions = [];

        if (isset($config['driver_options']) && is_array($config['driver_options'])) {
            $driverOptions = $config['driver_options'];
        }

        // Check if the credentials are not already set in the options
        if (!isset($credentials['username']) && !empty($config['username'])) {
            $credentials['username'] = $config['username'];
        }
        if (!isset($credentials['password']) && !empty($config['password'])) {
            $credentials['password'] = $config['password'];
        }
        return new ElasticManagement($dns, $credentials, $driverOptions);
    }

    /**
     *
     * @inheritdoc
     */
    public function disconnect()
    {
        unset($this->connection);
    }

    /**
     * Determine if the given configuration array has a Dns string.
     * @param array $config
     * @return bool
     */
    protected function hasDnsString(array $config)
    {
        return isset($config['host']) && !empty($config['host']);
    }

    /**
     * Get the Dns string form configuration.
     * @param array $config
     * @return string
     */
    protected function getDnsString(array $config)
    {
        return $config['host'];
    }

    /**
     * Get the Dns string for a host / port configuration.
     * @param array $config
     * @return string
     */
    protected function getHostDns(array $config)
    {
        // Treat host option as array of hosts
        $hosts = is_array($config['host']) ? $config['host'] : [$config['host']];
        $ssl = isset($config['ssl']) ? $config['ssl'] : true;

        foreach ($hosts as &$host) {
            // Check if we need to add a port to the host
            if (strpos($host, ':') === false && !empty($config['port'])) {
                $host = $host . ':' . $config['port'];
            }
        }

        $host = implode(',', $hosts);

        return $ssl
        ? 'https://' . $host
        : 'http://' . $host;
    }

    /**
     * Create a Dns string from a configuration.
     * @param array $config
     * @return string
     */
    protected function getDns(array $config)
    {
        return $this->hasDnsString($config)
        ? $this->getDnsString($config)
        : $this->getHostDns($config);
    }

    /**
     * @inheritdoc
     */
    public function getElapsedTime($start)
    {
        return parent::getElapsedTime($start);
    }

    protected function getPdoForSelect($useReadPdo = true)
    {
        return $this->connection;
    }

    /**
     * @inheritdoc
     */
    public function getDriverName()
    {
        return 'elastic';
    }

    /**
     * @inheritdoc
     */
    protected function getDefaultPostProcessor()
    {
        return new \Elastic\Query\Processor();
    }

    /**
     * @inheritdoc
     */
    protected function getDefaultQueryGrammar()
    {
        return new \Elastic\Query\Grammar();
    }

    /**
     * @inheritdoc
     */
    protected function getDefaultSchemaGrammar()
    {
        return new \Elastic\Schema\Grammar();
    }

    /**
     * Dynamically pass methods to the connection.
     * @param string $method
     * @param array $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        return call_user_func_array([$this->db, $method], $parameters);
    }
}
