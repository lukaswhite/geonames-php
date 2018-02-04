<?php namespace Lukaswhite\Geonames\Traits\Queries;

/**
 * Class HasCoordinates
 *
 * This trait indicates that a query type can have co-ordinates (lat/lng).
 *
 * @package Lukaswhite\Geonames\Traits\Queries
 */
trait HasCoordinates
{
    use \Lukaswhite\Geonames\Traits\Geo\HasCoordinates;

    /**
     * Add the coordiates (lat/lng) to a query
     *
     * @param $query
     */
    public function addCoordinatesToQuery( & $query )
    {
        if ( $this->getCoordinates( ) ) {
            $query[ 'lat' ] = $this->getCoordinates( )->getLatitude( );
            $query[ 'lng' ] = $this->getCoordinates( )->getLongitude( );
        }
    }

}