<?php namespace Lukaswhite\Geonames\Traits\Queries;

/**
 * Class CanSpecifyCharacterSet
 *
 * This trait indicates that a query type allows the character set to be explictly requested.
 *
 * @package Lukaswhite\Geonames\Traits\Queries
 */
trait CanSpecifyCharacterSet
{
    /**
     * Defines the encoding used for the document returned by the web service. Default is 'UTF8'
     *
     * @var string
     */
    private $charset;

    /**
     * Specify the required character set
     *
     * @param string $charset
     * @return $this
     */
    public function characterSet( $charset )
    {
        $this->charset = $charset;
        return $this;
    }

    /**
     * Optionally specify the character set
     *
     * @param $query
     */
    public function addCharacterSetToQuery( & $query )
    {
        if ( $this->charset ) {
            $query[ 'charset' ] = $this->charset;
        }
    }

}