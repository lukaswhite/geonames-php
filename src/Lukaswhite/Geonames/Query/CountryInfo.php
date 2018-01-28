<?php namespace Lukaswhite\Geonames\Query;

use Lukaswhite\Geonames\Contracts\QueriesService;
use Lukaswhite\Geonames\Traits\Geo\HasBoundingBox;
use Lukaswhite\Geonames\Traits\Queries\CanHaveOperator;
use Lukaswhite\Geonames\Traits\Queries\CanSpecifyCharacterSet;
use Lukaswhite\Geonames\Traits\Queries\CanSpecifyLanguage;
use Lukaswhite\Geonames\Traits\Queries\FiltersByCountry;
use Lukaswhite\Geonames\Traits\Queries\HasPagination;
use Lukaswhite\Geonames\Traits\Queries\CanSpecifyVerbosity;

/**
 * Class CountryInfo
 *
 * Country Info (Bounding Box, Capital, Area in square km, Population)
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