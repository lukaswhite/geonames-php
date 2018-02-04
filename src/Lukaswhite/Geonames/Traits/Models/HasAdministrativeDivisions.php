<?php namespace Lukaswhite\Geonames\Traits\Models;

use Lukaswhite\Geonames\Models\AdministrativeDivision;

/**
 * Trait HasAdministrativeDivisions
 *
 * @package Lukaswhite\Geonames\Traits\Models
 */
trait HasAdministrativeDivisions
{
    /**
     * The administrative divisions
     *
     * @var array
     */
    private $administrativeDivisions = [ ];

    /**
     * Get the administrative division at the specified level
     *
     * @param integer $level
     * @return AdministrativeDivision
     */
    public function getAdministrativeDivision( $level )
    {
        return ( $this->hasAdministrativeDivision( $level ) ) ?
            $this->administrativeDivisions[ $level ] :
            null;

    }

    /**
     * Set the administrative division at the specified level
     *
     * @param integer $level
     * @param AdministrativeDivision $divsion
     * @return $this
     */
    public function setAdministrativeDivision( $level, AdministrativeDivision $divsion )
    {
        $this->administrativeDivisions[ $level ] = $divsion;
        return $this;
    }

    /**
     * Add an administrative division
     *
     * @param AdministrativeDivision $area
     * @return $this
     */
    public function addAdministrativeDivision( AdministrativeDivision $divsion )
    {
        $this->setAdministrativeDivision( $divsion->getLevel( ), $divsion );
        return $this;
    }

    /**
     * Get the top-level administrative division.
     *
     * @return AdministrativeDivision|null
     */
    public function getTopLevelAdministrativeDivision( )
    {
        if ( count( $this->administrativeDivisions ) == 0 ) {
            return null;
        }
        return $this->getAdministrativeDivision( min( array_keys( $this->administrativeDivisions ) ) );
    }

    /**
     * Get the lowest-level administrative division.
     *
     * @return AdministrativeDivision|null
     */
    public function getLowestLevelAdministrativeDivision( )
    {
        if ( count( $this->administrativeDivisions ) == 0 ) {
            return null;
        }
        return $this->getAdministrativeDivision( max( array_keys( $this->administrativeDivisions ) ) );
    }

    /**
     * Determine whether this entity has an administrative division at the specified level
     *
     * @param int $level
     * @return bool
     */
    public function hasAdministrativeDivision( $level )
    {
        return isset( $this->administrativeDivisions[ $level ] );
    }

    /**
     * Get the next administrative division up from the specified level.
     *
     * E.g. if there are three levels, 1 to 3, and you pass 3 then you'll get the admin level at 2.
     *
     * One of the quirks of the Geonames data is that there are often features where admin levels 1 and 3 are
     * set but not 2. In that situation, it'll return 1.
     *
     * @param int $level
     * @return AdministrativeDivision
     * @throws \InvalidArgumentException
     */
    public function getNextAdministrativeLevelUpFrom( $level )
    {
        if ( $level == 1 ) {
            throw new \InvalidArgumentException( 'Cannot get an admin level up from level one' );
        }

        // Find the levels that are higher; so for example if we have 1, 2 and 3 and
        // $level is equal to 3 then it'll return [ 1, 2 ]
        $higherLevels = array_filter(
            array_keys( $this->administrativeDivisions ),
            function( $l ) use ( $level ) {
                return ( $l < $level );
            }
        );

        // We then want the maximum of those levels
        return $this->getAdministrativeDivision( max( $higherLevels ) );

    }

    /**
     * Get the current administrative division levels; i.e. an array of level numbers.
     *
     * @return array
     */
    public function getAdministrativeDivisionLevels( )
    {
        return array_keys( $this->administrativeDivisions );
    }

}