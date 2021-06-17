<?php

namespace Elastic\Query;

use Closure;
use Elastic\Driver\Connection;
use Illuminate\Database\Query\Builder as BaseBuilder;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

/**
 * Class Builder.
 */
class Builder extends BaseBuilder
{
    /**
     * The database collection.
     * @var \MongoDB\Collection
     */
    protected $collection;

    /**
     * The column projections.
     * @var array
     */
    public $projections;

    /**
     * The cursor timeout value.
     * @var int
     */
    public $timeout;

    /**
     * The cursor hint value.
     * @var int
     */
    public $hint;

    /**
     * Custom options to add to the query.
     * @var array
     */
    public $options = [];

    /**
     * Indicate if we are executing a pagination query.
     * @var bool
     */
    public $paginating = false;

    /**
     * All of the available clause operators.
     * @var array
     */
    public $operators = [
        '=',
        '<',
        '>',
        '<=',
        '>=',
        '<>',
        '!=',
        'like',
        'not like',
        'between',
        'ilike',
        '&',
        '|',
        '^',
        '<<',
        '>>',
        'rlike',
        'regexp',
        'not regexp',
        'exists',
        'type',
        'mod',
        'where',
        'all',
        'size',
        'regex',
        'text',
        'slice',
        'elemmatch',
        'geowithin',
        'geointersects',
        'near',
        'nearsphere',
        'geometry',
        'maxdistance',
        'center',
        'centersphere',
        'box',
        'polygon',
        'uniquedocs',
    ];

    /**
     * Operator conversion.
     * @var array
     */
    protected $conversion = [
        '=' => '=',
        '!=' => '$ne',
        '<>' => '$ne',
        '<' => '$lt',
        '<=' => '$lte',
        '>' => '$gt',
        '>=' => '$gte',
    ];

    /**
     * @inheritdoc
     */
    public function __construct(
        Connection $connection,
        Grammar $grammar,
        Processor $processor
    ) {
        $this->grammar = $grammar;
        $this->connection = $connection;
        $this->processor = $processor;
    }

    /**
     * Set the table which the query is targeting.
     *
     * @param  \Closure|\Illuminate\Database\Query\Builder|string  $table
     * @param  string|null  $as
     * @return $this
     */
    public function from($table, $as = null)
    {

        $this->from = "{$table}/_search";

        return $this;
    }

}
