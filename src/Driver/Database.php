<?php

namespace Elastic\Driver;

class Database extends ElasticManagement
{

    public function __construct($manager, $index, $options)
    {

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

    // hola mudno
    public function selectCollection($name)
    {
        return $name;
    }
}
