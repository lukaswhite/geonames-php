<?php namespace Lukaswhite\Geonames\Traits\Models;

/**
 * Class HasGeonamesId
 *
 * @package Lukaswhite\Geonames\Traits\Models
 */
trait HasGeonamesId
{
    /**
     * The unique Geonames Id
     *
     * @var integer
     */
    private $id;

    /**
     * Get the unique Geonames ID
     *
     * @return int
     */
    public function getId( ): int
    {
        return $this->id;
    }

    /**
     * Set the unique Geonames ID
     *
     * @param int $id
     * @return $this
     */
    public function setId( int $id )
    {
        $this->id = $id;
        return $this;
    }

}