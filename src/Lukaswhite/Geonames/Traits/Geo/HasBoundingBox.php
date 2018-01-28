<?php namespace Lukaswhite\Geonames\Traits\Geo;

use Lukaswhite\Geonames\Models\BoundingBox;

/**
 * Trait HasBoundingBox
 *
 * @package Lukaswhite\Geonames\Traits\Geo
 */
trait HasBoundingBox
{
    /**
     * The bounding box
     *
     * @var BoundingBox
     */
    private $boundingBox;

    /**
     * Set the bounding box
     *
     * @param BoundingBox|array $boundingBox
     * @return $this
     */
    public function setBoundingBox( $boundingBox )
    {
        if ( is_object( $boundingBox ) && $boundingBox instanceof BoundingBox ) {
            $this->boundingBox = $boundingBox;
        } elseif ( is_array( $boundingBox ) ) {
            $this->boundingBox = new BoundingBox( );
            $this->boundingBox->setNorth( $boundingBox[ 'north' ] );
            $this->boundingBox->setEast( $boundingBox[ 'east' ] );
            $this->boundingBox->setSouth( $boundingBox[ 'south' ] );
            $this->boundingBox->setWest( $boundingBox[ 'west' ] );
        }

        return $this;
    }

    /**
     * Get the bounding box
     *
     * @return BoundingBox
     */
    public function getBoundingBox( )
    {
        return $this->boundingBox;
    }

    /**
     * Parameterize the bounding box; this is used to query by bounding box.
     *
     * @return array
     */
    public function parameterizeBoundingBox( )
    {
        if ( ! $this->boundingBox ) {
            return [ ];
        }
        return [
            'north' =>  $this->boundingBox->getNorth( ),
            'east' =>  $this->boundingBox->getEast( ),
            'south' =>  $this->boundingBox->getSouth( ),
            'west' =>  $this->boundingBox->getWest( ),
        ];
    }

}