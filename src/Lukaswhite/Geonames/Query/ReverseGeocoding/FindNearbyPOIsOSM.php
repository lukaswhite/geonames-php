<?php namespace Lukaswhite\Geonames\Query\ReverseGeocoding;

use Lukaswhite\Geonames\Traits\Queries\HasPagination;

/**
 * Class FindNearbyPOIsOSM
 *
 * A reverse geocoding query to find nearby POIs (Points Of Interest)
 *
 * @package Lukaswhite\Geonames\Query
 */
class FindNearbyPOIsOSM extends AbstractReverseGeocoding
{
    use HasPagination;

    /**
     * Get the URI for this query
     *
     * @return string
     */
    public function getUri( )
    {
        return 'findNearbyPOIsOSM';
    }

    /**
     * This method declares the type of entity(ies) that this query expects to get in return.
     *
     * @return string
     */
    public function expects( )
    {
        return 'pois';
    }

    /**
     * Build the query
     *
     * @return array
     */
    public function build( )
    {
        $query = parent::build( );

        $this->addPagingToQuery( $query );

        return $query;
    }

}