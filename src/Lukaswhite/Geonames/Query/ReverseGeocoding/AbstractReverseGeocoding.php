<?php namespace Lukaswhite\Geonames\Query\ReverseGeocoding;

use Lukaswhite\Geonames\Contracts\QueriesService;
use Lukaswhite\Geonames\Models\Coordinate;
use Lukaswhite\Geonames\Traits\Queries\HasCoordinates;
use Lukaswhite\Geonames\Traits\Queries\HasRadius;

/**
 * Class AbstractReverseGeocoding
 *
 * A reverse geocoding query
 *
 * @package Lukaswhite\Geonames\Query
 */
abstract class AbstractReverseGeocoding implements QueriesService
{
    use HasCoordinates,
        HasRadius;

    /**
     * AbstractReverseGeocoding constructor.
     *
     * @param Coordinate $coordinates
     */
    public function __construct( Coordinate $coordinates )
    {
        $this->coordinates = $coordinates;
    }

    /**
     * Get the URI for this query
     *
     * @return string
     * @codeCoverageIgnore
     */
    public function getUri( )
    {
        return '';
    }

    /**
     * This method declares the type of entity(ies) that this query expects to get in return.
     *
     * @return string
     * @codeCoverageIgnore
     */
    public function expects( )
    {
        return '';
    }

    /**
     * Build the query
     *
     * @return array
     */
    public function build( )
    {
        $query = [ ];

        $this->addCoordinatesToQuery( $query );
        $this->addRadiusToQuery( $query );

        return $query;

    }

}