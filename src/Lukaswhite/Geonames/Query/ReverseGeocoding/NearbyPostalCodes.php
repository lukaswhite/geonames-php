<?php namespace Lukaswhite\Geonames\Query\ReverseGeocoding;

use Lukaswhite\Geonames\Models\Coordinate;
use Lukaswhite\Geonames\Traits\Queries\HasCoordinates;
use Lukaswhite\Geonames\Traits\Queries\CanSpecifyVerbosity;
use Lukaswhite\Geonames\Traits\Queries\FiltersByCountry;
use Lukaswhite\Geonames\Traits\Queries\HasPagination;
use Lukaswhite\Geonames\Traits\Queries\HasRadius;

/**
 * Class NearbyPostalCodes
 *
 * A reverse geocoding query to find nearby postal codes.
 *
 * @package Lukaswhite\Geonames\Query
 */
class NearbyPostalCodes
{
    use HasCoordinates,
        HasRadius,
        HasPagination,
        CanSpecifyVerbosity,
        FiltersByCountry;

    /**
     * NearbyPostalCodes constructor.
     *
     * Note that this differs from most reverse geocoding queries, in that you can either base
     * it on a set of lat/lng co-rdinates, OR on a postal code.
     *
     * @param Coordinate|string|integer $location
     */
    public function __construct( $location )
    {
        if ( is_object( $location ) && $location instanceof Coordinate ) {
            $this->coordinates = $location;
        } else {
            $this->postalCode = $location;
        }
    }

    /**
     * Get the URI for this query
     *
     * @return string
     */
    public function getUri( )
    {
        return 'findNearbyPostalCodes';
    }

    /**
     * This method declares the type of entity(ies) that this query expects to get in return.
     *
     * @return string
     */
    public function expects( )
    {
        return 'codes';
    }

    /**
     * You can base a nearby postal codes query on a postcode, rather than a co-ordinate.
     * This holds that postal code.
     *
     * @var mixed
     */
    private $postalCode;

    /**
     * In border areas this parameter will restrict the search on the local country
     *
     * @var bool
     */
    private $localCountry;

    /**
     * Restrict the query to the local country
     *
     * @param bool $localCountry
     */
    public function justLocalCountry( $localCountry = true )
    {
        $this->localCountry = $localCountry;
    }

    /**
     * Build the query
     *
     * Note that we're not using the build( ) method from the abstract reverse geocoding
     * query here, because we  don't always have co-ordinates.
     *
     * @return array
     */
    public function build( )
    {
        $query = [ ];

        // Either add the co-ordinates, or the postal code
        if ( $this->coordinates ) {
            $this->addCoordinatesToQuery( $query );
        } else {
            $query[ 'postalcode' ] = $this->postalCode;
        }

        $this->addRadiusToQuery( $query );

        if ( $this->localCountry ) {
            $query[ 'localCountry' ] = $this->localCountry;
        }

        $this->addStyleToQuery( $query );
        $this->addPagingToQuery( $query );

        return $query;
    }

}