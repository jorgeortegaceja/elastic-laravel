<?php

namespace Elastic\Driver;

class Database
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

}
