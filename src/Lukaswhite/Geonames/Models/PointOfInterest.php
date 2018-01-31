<?php namespace Lukaswhite\Geonames\Models;

use Lukaswhite\Geonames\Contracts\HasCoordinates as HasCoordinatesContract;
use Lukaswhite\Geonames\Traits\Geo\HasCoordinates;
use Lukaswhite\Geonames\Traits\Models\HasDistance;
use Lukaswhite\Geonames\Traits\Models\HasName;

/**
 * Class PointOfInterest
 *
 * Represents a Point Of Interest (POI)
 *
 * @package Lukaswhite\Geonames\Models
 */
class PointOfInterest implements HasCoordinatesContract
{
    use HasName,
        HasCoordinates,
        HasDistance;

    /**
     * The type class; e.g. amenity, shop
     *
     * @var string
     */
    private $typeClass;

    /**
     * The type name; e.g. fire_hydrant, school, cafe
     * @var string
     */
    private $typeName;

    /**
     * @return string
     */
    public function getTypeClass(): string
    {
        return $this->typeClass;
    }

    /**
     * @param string $typeClass
     * @return PointOfInterest
     */
    public function setTypeClass( string $typeClass ): PointOfInterest
    {
        $this->typeClass = $typeClass;
        return $this;
    }

    /**
     * @return string
     */
    public function getTypeName(): string
    {
        return $this->typeName;
    }

    /**
     * @param string $typeName
     * @return PointOfInterest
     */
    public function setTypeName( string $typeName ): PointOfInterest
    {
        $this->typeName = $typeName;
        return $this;
    }

    /**
     * Convert this point of interest into a string representation
     *
     * @return string
     */
    public function __toString()
    {
        // If the name has been specified, return that
        if ( $this->name && strlen( $this->name ) ) {
            return $this->name;
        }

        // If there's no name then just return the type name
        return $this->typeName;
    }
}