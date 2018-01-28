<?php namespace Lukaswhite\Geonames\Traits\Queries;

/**
 * Class FiltersByCountry
 *
 * This trait indicates that a query type allows results to be filtered by country
 *
 * @package Lukaswhite\Geonames\Traits\Queries
 */
trait FiltersByCountry
{
    /**
     * The countries to limit the query to
     *
     * @var array
     */
    private $countries = [ ];

    /**
     * Limit the query to those results in the specified country
     *
     * @param string|Country
     * @return $this
     */
    public function inCountry( $country )
    {
        if ( is_object( $country ) ) {
            $this->countries[ ] = $country->getCode( );
        } else {
            $this->countries[ ] = $country;
        }
        return $this;
    }

    /**
     * Limit the query to those results in the specified countries
     *
     * @param array|string
     * @return $this
     */
    public function inCountries( $countries )
    {
        foreach( $countries as $country ) {
            $this->inCountry( $country );
        }
        return $this;
    }

    /**
     * Optionally add the country filters to the query
     *
     * @param array
     */
    private function addCountryFiltersToQuery( & $query )
    {
        if ( count( $this->countries ) ) {
            $query[ 'country' ] = $this->countries;
        }
    }

}