<?php namespace Lukaswhite\Geonames\Traits\Models;

use Lukaswhite\Geonames\Models\AdministrativeArea;

/**
 * Trait HasAdminCodes
 *
 * @package Lukaswhite\Geonames\Traits\Models
 */
trait HasAdminCodes
{
    /**
     * Admin code, level 1
     *
     * @var string
     */
    private $adminCode1;

    /**
     * Admin code, level 2
     *
     * @var string
     */
    private $adminCode2;

    /**
     * Admin code, level 3
     *
     * @var string
     */
    private $adminCode3;

    /**
     * Admin code name, level 1
     *
     * @var string
     */
    private $adminName1;

    /**
     * Admin code name, level 2
     *
     * @var string
     */
    private $adminName2;

    /**
     * Admin code name, level 3
     *
     * @var string
     */
    private $adminName3;


    /**
     * @return string
     */
    public function getAdminCode1(): string
    {
        return $this->adminCode1;
    }

    /**
     * @param string $adminCode1
     * @return $this
     */
    public function setAdminCode1( string $adminCode1 )
    {
        $this->adminCode1 = $adminCode1;
        return $this;
    }

    /**
     * @return string
     */
    public function getAdminCode2(): string
    {
        return $this->adminCode2;
    }

    /**
     * @param string $adminCode2
     * @return $this
     */
    public function setAdminCode2( string $adminCode2 )
    {
        $this->adminCode2 = $adminCode2;
        return $this;
    }

    /**
     * @return string
     */
    public function getAdminCode3(): string
    {
        return $this->adminCode3;
    }

    /**
     * @param string $adminCode3
     * @return $this
     */
    public function setAdminCode3( string $adminCode3 )
    {
        $this->adminCode3 = $adminCode3;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAdminName1()
    {
        return $this->adminName1;
    }

    /**
     * @param mixed $adminName1
     * @return $this
     */
    public function setAdminName1( $adminName1 )
    {
        $this->adminName1 = $adminName1;
        return $this;
    }

    /**
     * @return string
     */
    public function getAdminName2(): string
    {
        return $this->adminName2;
    }

    /**
     * @param string $adminName2
     * @return $this
     */
    public function setAdminName2( string $adminName2 )
    {
        $this->adminName2 = $adminName2;
        return $this;
    }

    /**
     * @return string
     */
    public function getAdminName3(): string
    {
        return $this->adminName3;
    }

    /**
     * @param string $adminName3
     * @return $this
     */
    public function setAdminName3( string $adminName3 )
    {
        $this->adminName3 = $adminName3;
        return $this;
    }

    /**
     * Get the maximum admin code level. In other words if the lone admin code is set but
     * not 2 or 3 then it returns 1. If levels 1 & 2 are set it returns 2. If all three are
     * set then it returns 3, and if none are set it returns 0.
     *
     * @return integer
     * @todo There are situations where 1 & 3 are set; what happens then?
     */
    public function getAdminCodeLevel( )
    {
        if ( $this->adminCode1 && $this->adminCode2 && $this->adminCode3 ) {
            return 3;
        }
        if ( $this->adminCode1 && $this->adminCode2 ) {
            return 2;
        }
        if ( $this->adminCode1 ) {
            return 1;
        }
        return 0;
    }

}