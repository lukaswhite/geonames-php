<?php namespace Lukaswhite\Geonames\Contracts;

/**
 * Interface HasAdminCodeNames
 *
 * @package Lukaswhite\Geonames\Contracts
 */
interface HasAdminCodeNames
{
    /**
     * @return mixed
     */
    public function getAdminName1();

    /**
     * @param mixed $adminName1
     * @return $this
     */
    public function setAdminName1( $adminName1 );

    /**
     * @return string
     */
    public function getAdminName2();

    /**
     * @param string $adminName2
     * @return $this
     */
    public function setAdminName2( string $adminName2 );

    /**
     * @return string
     */
    public function getAdminName3(): string;

    /**
     * @param string $adminName3
     * @return $this
     */
    public function setAdminName3( string $adminName3 );

}