<?php namespace Lukaswhite\Geonames\Query\ReverseGeocoding;

use Lukaswhite\Geonames\Query\ReverseGeocoding\AbstractReverseGeocoding;
use Lukaswhite\Geonames\Traits\Queries\CanSpecifyLanguage;
use Lukaswhite\Geonames\Traits\Queries\CanSpecifyVerbosity;
use Lukaswhite\Geonames\Traits\Queries\FiltersByFeature;
use Lukaswhite\Geonames\Traits\Queries\HasPagination;
use Lukaswhite\Geonames\Traits\Queries\SupportsCitiesParameter;

/**
 * Class Neighbourhood
 *
 * A reverse geocoding query to find the neighbourhood for US cities.
 *
 * @package Lukaswhite\Geonames\Query
 */
class Neighbourhood extends AbstractReverseGeocoding
{
    /**
     * Get the URI for this query
     *
     * @return string
     */
    public function getUri( )
    {
        return 'neighbourhood';
    }

    /**
     * This method declares the type of entity(ies) that this query expects to get in return.
     *
     * @return string
     */
    public function expects( )
    {
        return 'neighbourhood';
    }
}