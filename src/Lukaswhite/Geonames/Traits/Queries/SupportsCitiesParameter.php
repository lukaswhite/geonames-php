<?php namespace Lukaswhite\Geonames\Traits\Queries;

/**
 * Class SupportsCitiesParameter
 *
 * This trait indicates that a query type supports the cities parameter.
 *
 * @package Lukaswhite\Geonames\Traits\Queries
 */
trait SupportsCitiesParameter
{
    /**
     * The cities; this is used to categorize the populated places into three groups according to size/relevance
     *
     * @var string
     */
    private $cities;

    /**
     * Set the cities; this is used to categorize the populated places into three groups according to size/relevance
     *
     * @param $value
     * @return $this
     */
    public function cities( $value )
    {
        if ( ! in_array(
            $value,
            [
                'cities1000',
                'cities5000',
                'cities15000',
            ]
        ) ) {
            throw new \InvalidArgumentException( 'Invalid cities' );
        }

        $this->cities = $value;

        return $this;
    }

    /**
     * Restrict the selection to cities with a population of at least 1000. This is essentially
     * just syntactic sugar for ->cities( 'cities1000' )
     *
     * @return $this
     */
    public function populationOver1000( )
    {
        return $this->cities( 'cities1000' );
    }

    /**
     * Restrict the selection to cities with a population of at least 5000. This is essentially
     * just syntactic sugar for ->cities( 'cities5000' )
     *
     * @return $this
     */
    public function populationOver5000( )
    {
        return $this->cities( 'cities5000' );
    }

    /**
     * Restrict the selection to cities with a population of at least 15,000. This is essentially
     * just syntactic sugar for ->cities( 'cities15000' )
     *
     * @return $this
     */
    public function populationOver15000( )
    {
        return $this->cities( 'cities15000' );
    }

    /**
     * Add the cities parameter to a query
     *
     * @param array $query
     */
    private function addCitiesParameterToQuery( & $query )
    {
        if ( isset( $this->cities ) ) {
            $query[ 'cities' ] = $this->cities;
        }
    }
}