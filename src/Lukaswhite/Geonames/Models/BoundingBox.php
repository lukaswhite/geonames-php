<?php namespace Lukaswhite\Geonames\Models;

/**
 * Class BoundingBox
 *
 * Represents a bounding box; i.e. a rectangular geographical area.
 *
 * @package Lukaswhite\Geonames\Models
 */
class BoundingBox
{
    /**
     * The northern point
     *
     * @var float
     */
    private $north;

    /**
     * The eastern point
     *
     * @var float
     */
    private $east;

    /**
     * The southern point
     *
     * @var float
     */
    private $south;

    /**
     * The western point
     *
     * @var float
     */
    private $west;

    /**
     * The accuracy level
     *
     * @var int
     */
    private $accuracyLevel;

    /**
     * Constructor
     *
     * @param array $points
     */
    public function __construct( array $points = [ ] )
    {
        if ( count( $points ) ) {
            foreach( $points as $axis => $value ) {
                if ( property_exists( $this, $axis ) ) {
                    $this->$axis = $value;
                }
            }
        }
    }

    /**
     * @return float
     */
    public function getNorth(): float
    {
        return $this->north;
    }

    /**
     * @param float $north
     * @return BoundingBox
     */
    public function setNorth( float $north ): BoundingBox
    {
        $this->north = $north;
        return $this;
    }

    /**
     * @return float
     */
    public function getEast(): float
    {
        return $this->east;
    }

    /**
     * @param float $east
     * @return BoundingBox
     */
    public function setEast( float $east ): BoundingBox
    {
        $this->east = $east;
        return $this;
    }

    /**
     * @return float
     */
    public function getSouth(): float
    {
        return $this->south;
    }

    /**
     * @param float $south
     * @return BoundingBox
     */
    public function setSouth( float $south ): BoundingBox
    {
        $this->south = $south;
        return $this;
    }

    /**
     * @return float
     */
    public function getWest(): float
    {
        return $this->west;
    }

    /**
     * @param float $west
     * @return BoundingBox
     */
    public function setWest( float $west ): BoundingBox
    {
        $this->west = $west;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAccuracyLevel()
    {
        return $this->accuracyLevel;
    }

    /**
     * @param mixed $accuracyLevel
     * @return BoundingBox
     */
    public function setAccuracyLevel( $accuracyLevel )
    {
        $this->accuracyLevel = $accuracyLevel;
        return $this;
    }

    /**
     * Get the North West co-ordinate
     *
     * @return Coordinate
     */
    public function getNorthWest( )
    {
        return new Coordinate( [ $this->north, $this->west ] );
    }

    /**
     * Set the North West co-ordinate
     *
     * @param Coordinate $coordinates
     * @return $this
     */
    public function setNorthWest( Coordinate $coordinates )
    {
        $this->north = $coordinates->getLatitude( );
        $this->west = $coordinates->getLongitude( );
        return $this;
    }

    /**
     * Get the South East co-ordinate
     *
     * @return Coordinate
     */
    public function getSouthEast( )
    {
        return new Coordinate( [ $this->south, $this->east ] );
    }

    /**
     * Set the South East co-ordinate
     *
     * @param Coordinate $coordinates
     * @return $this
     */
    public function setSouthEast( Coordinate $coordinates )
    {
        $this->south = $coordinates->getLatitude( );
        $this->east = $coordinates->getLongitude( );
        return $this;
    }

}