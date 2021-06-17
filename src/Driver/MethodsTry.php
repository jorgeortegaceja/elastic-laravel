<?php

namespace Elastic\Driver;

trait MethodsTry
{

    public function table($table, $as = null)
    {
        return $this->query()->from($table, $as);
    }

    /**
     * Get a new query builder instance.
     *
     * @return \Illuminate\Database\Query\Builder
     */
    public function query()
    {
        return new \Elastic\Query\Builder(
            $this, $this->getQueryGrammar(), $this->getPostProcessor()
        );
    }
}
