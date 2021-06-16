<?php

namespace Elastic\Driver;

class Database extends ElasticManagement
{
    protected $options;

    public function __construct($manager, $index, $options)
    {
        $this->options = $options;   
    }

    public function connetion()
    {

    }

    public function statement(Stirng $query)
    {
        return $this;
    }

    public function attachment($array)
    {
        return $this;
    }

    public function getPDO()
    {
        return $this;
    }

    public function find($query)
    {
        return $this->execute($query, $this->options);
    }

    // hola mudno
    public function selectCollection($name)
    {
        return $name;
    }
}
