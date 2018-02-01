<?php namespace Lukaswhite\Geonames\Contracts;

use Lukaswhite\Geonames\Models\AdministrativeArea;

/**
 * Interface HasAdministrativeAreas
 *
 * @package Lukaswhite\Geonames\Contracts
 */
interface HasAdministrativeAreas
{
    /**
     * Get the administrative area at the specified level
     *
     * @param integer $level
     * @return AdministrativeArea
     */
    public function getAdministrativeArea( $level );

    /**
     * Set the administrative area at the specified level
     *
     * @param integer $level
     * @param AdministrativeArea $area
     * @return $this
     */
    public function setAdministrativeArea( $level, AdministrativeArea $area );

    /**
     * Add an administrative area
     *
     * @param AdministrativeArea $area
     * @return $this
     */
    public function addAdministrativeArea( AdministrativeArea $area );
}