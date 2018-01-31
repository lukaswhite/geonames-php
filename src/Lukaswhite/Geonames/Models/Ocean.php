<?php namespace Lukaswhite\Geonames\Models;

use Lukaswhite\Geonames\Traits\Models\HasName;

/**
 * Class Ocean
 *
 * Represents, as the name implies, an ocean.
 *
 * @package Lukaswhite\Geonames\Models
 */
class Ocean extends PostalCode
{
    use HasName;

    /**
     * Ocean constructor.
     *
     * @param string $name
     */
    public function __construct( $name )
    {
        $this->name = $name;
    }

    /**
     * Convert this ocean into a string representation
     *
     * @return string
     */
    public function __toString()
    {
        return $this->name;
    }
}