<?php namespace Lukaswhite\Geonames\Contracts;

/**
 * Interface HasAdminCodes
 *
 * @package Lukaswhite\Geonames\Contracts
 */
interface HasAdminCodes
{
    /**
     * @return string
     */
    public function getAdminCode1(): string;

    /**
     * @param string $adminCode1
     * @return $this
     */
    public function setAdminCode1( string $adminCode1 );

    /**
     * @return string
     */
    public function getAdminCode2(): string;

    /**
     * @param string $adminCode2
     * @return $this
     */
    public function setAdminCode2( string $adminCode2 );

    /**
     * @return string
     */
    public function getAdminCode3(): string;

    /**
     * @param string $adminCode3
     * @return $this
     */
    public function setAdminCode3( string $adminCode3 );

    /**
     * Get the maximum admin code level. In other words if the lone admin code is set but
     * not 2 or 3 then it returns 1. If levels 1 & 2 are set it returns 2. If all three are
     * set then it returns 3, and if none are set it returns 0.
     *
     * @return integer
     */
    public function getAdminCodeLevel( );
}