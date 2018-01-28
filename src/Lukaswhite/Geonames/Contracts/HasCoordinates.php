<?php namespace Lukaswhite\Geonames\Contracts;

use Lukaswhite\Geonames\Models\Coordinate;

/**
 * Interface HasCoordinates
 *
 * @package Lukaswhite\Geonames\Contracts
 */
interface HasCoordinates
{
    /**
     * @return Coordinate
     */
    public function getCoordinates(): Coordinate;

    /**
     * @param Coordinate $coordinates
     * @return $this
     */
    public function setCoordinates( Coordinate $coordinates );

    /**
     * Get the latitude; essentially just a shortcut to ->coordinates->getLatitude( )
     *
     * @return float
     */
    public function getLatitude( );

    /**
     * Get the longitude; essentially just a shortcut to ->coordinates->getLongitude( )
     *
     * @return float
     */
    public function getLongitude( );
}