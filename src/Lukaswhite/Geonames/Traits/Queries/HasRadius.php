<?php namespace Lukaswhite\Geonames\Traits\Queries;

/**
 * Class HasRadius
 *
 * This trait indicates that a query type can include a radius
 *
 * @package Lukaswhite\Geonames\Traits\Queries
 */
trait HasRadius
{
    /**
     * The radius; e.g. when searching based on a lat/lng, this defines the maxiumum search radius.
     *
     * @var integer
     */
    private $radius;

    /**
     * Restricts the search to those results within the specified radius.
     *
     * @param integer $radius
     * @return $this
     */
    public function withinRadius( $radius )
    {
        $this->radius = $radius;
        return $this;
    }

    /**
     * Add the radius to a query
     *
     * @param array $query
     */
    protected function addRadiusToQuery( & $query )
    {
        if ( isset( $this->radius ) ) {
            $query[ 'radius' ] = $this->radius;
        }
    }
}