<?php namespace Lukaswhite\Geonames\Contracts;

use Lukaswhite\Geonames\Models\AdministrativeDivision;

/**
 * Interface HasAdministrativeDivisions
 *
 * @package Lukaswhite\Geonames\Contracts
 */
interface HasAdministrativeDivisions
{
    /**
     * Get the administrative area at the specified level
     *
     * @param integer $level
     * @return AdministrativeDivision
     */
    public function getAdministrativeDivision( $level );

    /**
     * Set the administrative area at the specified level
     *
     * @param integer $level
     * @param AdministrativeDivision $area
     * @return $this
     */
    public function setAdministrativeDivision( $level, AdministrativeDivision $area );

    /**
     * Add an administrative area
     *
     * @param AdministrativeDivision $area
     * @return $this
     */
    public function addAdministrativeDivision( AdministrativeDivision $area );

    /**
     * Determine whether this entity has an administrative area at the specified level
     *
     * @param int $level
     * @return bool
     */
    public function hasAdministrativeDivision( $level );

    /**
     * Get the next administrative level up from the specified level.
     *
     * E.g. if there are three levels, 1 to 3, and you pass 3 then you'll get the admin level at 2.
     *
     * One of the quirks of the Geonames data is that there are often features where admin levels 1 and 3 are
     * set but not 2. In that situation, it'll return 1.
     *
     * @param int $level
     * @return AdministrativeDivision
     */
    public function getNextAdministrativeLevelUpFrom( $level );

}