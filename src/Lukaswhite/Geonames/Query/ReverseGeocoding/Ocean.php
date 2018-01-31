<?php namespace Lukaswhite\Geonames\Query\ReverseGeocoding;

use Lukaswhite\Geonames\Query\ReverseGeocoding\AbstractReverseGeocoding;
use Lukaswhite\Geonames\Traits\Queries\CanSpecifyLanguage;
use Lukaswhite\Geonames\Traits\Queries\CanSpecifyVerbosity;
use Lukaswhite\Geonames\Traits\Queries\FiltersByFeature;
use Lukaswhite\Geonames\Traits\Queries\HasPagination;
use Lukaswhite\Geonames\Traits\Queries\SupportsCitiesParameter;

/**
 * Class Ocean
 *
 * A reverse geocoding query to find the ocean a point is in.
 *
 * @package Lukaswhite\Geonames\Query
 */
class Ocean extends AbstractReverseGeocoding
{
    /**
     * Get the URI for this query
     *
     * @return string
     */
    public function getUri( )
    {
        return 'ocean';
    }

    /**
     * This method declares the type of entity(ies) that this query expects to get in return.
     *
     * @return string
     */
    public function expects( )
    {
        return 'ocean';
    }
}