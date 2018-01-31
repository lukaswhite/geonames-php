<?php namespace Lukaswhite\Geonames\Query;

use Lukaswhite\Geonames\Contracts\QueriesService;
use Lukaswhite\Geonames\Traits\Queries\CanSpecifyLanguage;
use Lukaswhite\Geonames\Traits\Queries\FiltersByCountry;

/**
 * Class CountryInfo
 *
 * Country Info (Bounding Box, Capital, Area in square km, Population).
 *
 * By default it will return information for all countries, but you can also use inCountry( ) or
 * inCountries( ) to restrict the selection to one or more countries.
 *
 * @package Lukaswhite\Geonames\Query
 */
class CountryInfo implements QueriesService
{
    use FiltersByCountry,
        CanSpecifyLanguage;

    /**
     * Get the URI for this query
     *
     * @return string
     */
    public function getUri( )
    {
        return 'countryInfo';
    }

    /**
     * This method declares the type of entity(ies) that this query expects to get in return.
     *
     * @return string
     */
    public function expects( )
    {
        return 'countries';
    }

    /**
     * Build the query
     *
     * @return array
     */
    public function build( )
    {
        $query = [ ];

        $this->addCountryFiltersToQuery( $query );
        $this->addLanguageToQuery( $query );

        return $query;

    }

}