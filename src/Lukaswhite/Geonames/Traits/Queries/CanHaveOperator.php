<?php namespace Lukaswhite\Geonames\Traits\Queries;

/**
 * Class CanHaveOperator
 *
 * This trait indicates that a query type can include the operator
 *
 * @package Lukaswhite\Geonames\Traits\Queries
 */
trait CanHaveOperator
{
    /**
     * The search operator (AND / OR)
     *
     * @var string
     */
    private $operator;

    /**
     * Set the operator
     *
     * @param string
     * @return $this
     */
    public function operator( $value )
    {
        $operator = strtoupper( $value );
        if ( ! in_array( $operator, [ 'AND', 'OR' ] ) ) {
            throw new \InvalidArgumentException( 'Invalid operator' );
        }
        $this->operator = $operator;
        return $this;
    }

    /**
     * Use the AND operator; basically syntactic sugar for operator( 'AND' )
     *
     * @return $this
     */
    public function andOperator( )
    {
        return $this->operator( 'AND' );
    }

    /**
     * Use the OR operator; basically syntactic sugar for operator( 'OR' )
     *
     * @return $this
     */
    public function orOperator( )
    {
        return $this->operator( 'OR' );
    }

    /**
     * Add the operator to a query
     *
     * @param array $query
     */
    private function addOperatorToQuery( & $query )
    {
        if ( isset( $this->operator ) ) {
            $query[ 'operator' ] = $this->operator;
        }
    }

}