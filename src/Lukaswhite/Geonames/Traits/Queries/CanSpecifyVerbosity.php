<?php namespace Lukaswhite\Geonames\Traits\Queries;

/**
 * Class CanSpecifyVerbosity
 *
 * This trait indicates that a query type allows the verbosity (style) to be specified.
 *
 * @package Lukaswhite\Geonames\Traits\Queries
 */
trait CanSpecifyVerbosity
{
    /**
     * The verbosity of the returned document
     *
     * @var string
     */
    private $style;

    /**
     * Set the verbosity of the returned document (style)
     *
     * @param string $value
     * @return $this
     */
    public function style( $value )
    {
        $style = strtoupper( $value );
        if ( ! in_array( $style, [ 'SHORT', 'MEDIUM', 'LONG', 'FULL' ] ) ) {
            throw new \InvalidArgumentException( 'Invalid style' );
        }
        $this->style = $style;
        return $this;
    }

    /**
     * Set to short style (verbosity); basically syntactic sugar for style( 'SHORT' )
     *
     * @return $this
     */
    public function short( )
    {
        return $this->style( 'SHORT' );
    }

    /**
     * Set to medium style (verbosity); basically syntactic sugar for style( 'MEDIUM' )
     *
     * @return $this
     */
    public function medium( )
    {
        return $this->style( 'MEDIUM' );
    }

    /**
     * Set to long style (verbosity); basically syntactic sugar for style( 'LONG' )
     *
     * @return $this
     */
    public function long( )
    {
        return $this->style( 'LONG' );
    }

    /**
     * Set to full style (verbosity); basically syntactic sugar for style( 'FULL' )
     *
     * @return $this
     */
    public function full( )
    {
        return $this->style( 'FULL' );
    }

    public function addStyleToQuery( & $query )
    {
        // If the style has been explicitly specified, add that to the query
        if ( $this->style ) {
            $query[ 'style' ] = $this->style;
        }
    }

}