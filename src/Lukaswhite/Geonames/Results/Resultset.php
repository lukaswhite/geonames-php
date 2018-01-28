<?php namespace Lukaswhite\Geonames\Results;

/**
 * Class Resultset
 *
 * A simple class for encapsulating a set of results.
 *
 * @package Lukaswhite\Geonames\Results
 */
class Resultset implements \IteratorAggregate, \ArrayAccess, \Countable
{
    /**
     * The total number of results
     *
     * @var integer
     */
    private $total;

    /**
     * The actual results
     *
     * @var array
     */
    private $results;

    /**
     * Resultset constructor.
     *
     * @param array $results
     * @param integer $total
     */
    public function __construct( array $results, $total = null )
    {
        $this->results = $results;
        $this->total = $total;
    }

    /**
     * Get the iterator
     *
     * @return \ArrayIterator
     */
    public function getIterator( )
    {
        return new \ArrayIterator( $this->results );
    }

    /**
     * Get a count of the number of results in this resultset
     *
     * @return integer
     */
    public function count( )
    {
        return count( $this->results );
    }

    /**
     * Get the total number of results
     *
     * @return integer
     */
    public function total( )
    {
        return $this->total;
    }

    /**
     * Get the actual results, as a plain array
     *
     * @return array
     */
    public function getResults( )
    {
        return $this->results;
    }

    /**
     * Get the first result
     *
     * @return mixed
     */
    public function first( )
    {
        if ( $this->count( ) == 0 ) {
            return null;
        }
        return $this->results[ 0 ];
    }

    /**
     * Get the last result
     *
     * @return mixed
     */
    public function last( )
    {
        if ( $this->count( ) == 0 ) {
            return null;
        }
        return $this->results[ ( $this->count( ) - 1 ) ];
    }

    /**
     * Call the supplied function on every result in the collection and return the result.
     *
     * @param \Closure $func
     * @return Resultset
     */
    public function map( \Closure $func )
    {
        return new self( array_map(
            $func,
            $this->results
        ), $this->total( ) );
    }


    /**
     * Set the result at the specified offset
     *
     * @param integer $offset
     * @param mixed $value
     */
    public function offsetSet( $offset, $value )
    {
        $this->results[ $offset ] = $value;
    }

    /**
     * Check whether a result exists with the specified offset
     *
     * @param integer $offset
     * @return bool
     */
    public function offsetExists( $offset )
    {
        return isset( $this->results[ $offset ]);
    }

    /**
     * Un-set the result at the specified offset
     *
     * @param integer $offset
     */
    public function offsetUnset( $offset )
    {
        unset( $this->results[ $offset ] );
    }

    /**
     * Get the result at the specified offset
     *
     * @param integer $offset
     * @return mixed
     */
    public function offsetGet( $offset )
    {
        return isset( $this->results[ $offset ] ) ? $this->results[ $offset ] : null;
    }

}