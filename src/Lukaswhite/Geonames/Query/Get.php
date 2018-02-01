<?php namespace Lukaswhite\Geonames\Query;

use Lukaswhite\Geonames\Contracts\QueriesService;
use Lukaswhite\Geonames\Models\Feature;

/**
 * Class Get
 *
 * This simply returns Geonames feature information, by ID.
 *
 * @package Lukaswhite\Geonames\Query
 */
class Get implements QueriesService
{

    /**
     * The Geonames ID
     *
     * @var int
     */
    private $geonamesId;

    /**
     * Get constructor.
     *
     * @param integer|Feature $place
     */
    public function __construct( $place = null )
    {
        if ( $place ) {
            $this->setPlace( $place );
        }
    }

    /**
     * Get the URI for this query
     *
     * @return string
     */
    public function getUri( )
    {
        return 'get';
    }

    /**
     * This method declares the type of entity(ies) that this query expects to get in return.
     *
     * @return string
     */
    public function expects( )
    {
        return 'feature';
    }

    /**
     * Set the place.
     *
     * You can provide:
     *
     *  - a Feature object
     *  - a numeric Geonames ID
     *
     * @param integer|Feature $place
     * @return $this
     * @throws \InvalidArgumentException
     */
    public function setPlace( $place )
    {
        if ( is_integer( $place ) ) {
            $this->geonamesId = $place;
        } elseif ( is_object( $place ) && $place instanceof Feature ) {
            $this->geonamesId = $place->getId( );
        } else {
            throw new \InvalidArgumentException(
                'Requires Geonames ID, or an instance of the Feature class'
            );
        }

        return $this;
    }

    /**
     * Build the query
     *
     * @return array
     */
    public function build( )
    {
        return [
            'geonameId' => $this->geonamesId,
        ];

    }

}