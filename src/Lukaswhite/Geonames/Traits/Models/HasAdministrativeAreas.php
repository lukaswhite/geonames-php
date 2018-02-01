<?php namespace Lukaswhite\Geonames\Traits\Models;

use Lukaswhite\Geonames\Models\AdministrativeArea;

/**
 * Trait HasAdministrativeAreas
 *
 * @package Lukaswhite\Geonames\Traits\Models
 */
trait HasAdministrativeAreas
{
    /**
     * The administrative areas
     *
     * @var array
     */
    private $administrativeAreas = [ ];

    /**
     * Get the administrative area at the specified level
     *
     * @param integer $level
     * @return AdministrativeArea
     */
    public function getAdministrativeArea( $level )
    {
        return ( $this->hasAdministrativeArea( $level ) ) ?
            $this->administrativeAreas[ $level ] :
            null;

    }

    /**
     * Set the administrative area at the specified level
     *
     * @param integer $level
     * @param AdministrativeArea $area
     * @return $this
     */
    public function setAdministrativeArea( $level, AdministrativeArea $area )
    {
        $this->administrativeAreas[ $level ] = $area;
        return $this;
    }

    /**
     * Add an administrative area
     *
     * @param AdministrativeArea $area
     * @return $this
     */
    public function addAdministrativeArea( AdministrativeArea $area )
    {
        $this->setAdministrativeArea( $area->getLevel( ), $area );
        return $this;
    }

    /**
     * Get the top-level administrative area.
     *
     * @return AdministrativeArea|null
     */
    public function getTopLevelAdministrativeArea( )
    {
        if ( count( $this->administrativeAreas ) == 0 ) {
            return null;
        }
        return $this->getAdministrativeArea( min( array_keys( $this->administrativeAreas ) ) );
    }

    /**
     * Get the lowest-level administrative area.
     *
     * @return AdministrativeArea|null
     */
    public function getLowestLevelAdministrativeArea( )
    {
        if ( count( $this->administrativeAreas ) == 0 ) {
            return null;
        }
        return $this->getAdministrativeArea( max( array_keys( $this->administrativeAreas ) ) );
    }

    /**
     * Determine whether this entity has an administrative area at the specified level
     *
     * @param int $level
     * @return bool
     */
    public function hasAdministrativeArea( $level )
    {
        return isset( $this->administrativeAreas[ $level ] );
    }
}