<?php namespace Lukaswhite\Geonames\Query\ReverseGeocoding;

use Lukaswhite\Geonames\Query\ReverseGeocoding\AbstractReverseGeocoding;
use Lukaswhite\Geonames\Traits\Queries\CanSpecifyLanguage;
use Lukaswhite\Geonames\Traits\Queries\CanSpecifyVerbosity;
use Lukaswhite\Geonames\Traits\Queries\FiltersByFeature;
use Lukaswhite\Geonames\Traits\Queries\HasPagination;
use Lukaswhite\Geonames\Traits\Queries\SupportsCitiesParameter;

/**
 * Class ExtendedFindNearby
 *
 * A reverse geocoding query to find nearby toponym
 *
 * @package Lukaswhite\Geonames\Query
 */
class ExtendedFindNearby extends AbstractReverseGeocoding
{
    /**
     * Get the URI for this query
     *
     * @return string
     */
    public function getUri( )
    {
        return 'extendedFindNearby';
    }

    /**
     * This method declares the type of entity(ies) that this query expects to get in return.
     *
     * @return string
     */
    public function expects( )
    {
        return 'features|addresses';
    }

    /**
     * Build the query
     *
     * @return array
     */
    public function build( )
    {
        $query = parent::build( );

        return $query;
    }

}