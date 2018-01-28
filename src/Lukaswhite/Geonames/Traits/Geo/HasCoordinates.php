<?php namespace Lukaswhite\Geonames\Traits\Geo;

use Lukaswhite\Geonames\Models\Coordinate;

/**
 * Trait HasCoordinates
 *
 * @package Lukaswhite\Geonames\Traits\Geo
 */
trait HasCoordinates
{
    /**
     * The co-ordinates
     *
     * @var Coordinate
     */
    private $coordinates;

    /**
     * @return Coordinate
     */
    public function getCoordinates(): Coordinate
    {
        return $this->coordinates;
    }

    /**
     * @param Coordinate $coordinates
     * @return $this
     */
    public function setCoordinates( Coordinate $coordinates )
    {
        $this->coordinates = $coordinates;
        return $this;
    }

    /**
     * Get the latitude; essentially just a shortcut to ->coordinates->getLatitude( )
     *
     * @return float
     */
    public function getLatitude( )
    {
        return $this->coordinates->getLatitude( );
    }

    /**
     * Get the longitude; essentially just a shortcut to ->coordinates->getLongitude( )
     *
     * @return float
     */
    public function getLongitude( )
    {
        return $this->coordinates->getLongitude( );
    }

}