<?php namespace Lukaswhite\Geonames\Query;

use Lukaswhite\Geonames\Contracts\QueriesService;
use Lukaswhite\Geonames\Models\Feature;
use Lukaswhite\Geonames\Traits\Queries\FiltersByFeature;
use Lukaswhite\Geonames\Traits\Queries\HasPagination;
use Lukaswhite\Geonames\Traits\Queries\CanSpecifyVerbosity;

/**
 * Class Get
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
     */
    public function __construct( )
    {

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
        return 'geoname';
    }

    /**
     * Set the place. All hierarchy queries start with a single place.
     *
     * You can provide:
     *
     *  - a Feature object
     *  - a numeric Geonames ID
     *
     * @param integer|Feature $place
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