<?php namespace Lukaswhite\Geonames\Query\Hierarchy;

use Lukaswhite\Geonames\Contracts\QueriesService;
use Lukaswhite\Geonames\Models\Feature;
use Lukaswhite\Geonames\Traits\Queries\FiltersByFeature;
use Lukaswhite\Geonames\Traits\Queries\HasPagination;
use Lukaswhite\Geonames\Traits\Queries\CanSpecifyVerbosity;

/**
 * Class Neighbours
 *
 * @package Lukaswhite\Geonames\Query
 */
class Neighbours extends AbstractHierarchy implements QueriesService
{
    /**
     * The country code
     *
     * @var string
     */
    private $countryCode;

    /**
     * Hierarchy constructor.
     *
     * All hierarchy queries start with a single place.
     *
     * You can provide:
     *
     *  - a Feature object
     *  - a numeric Geonames ID
     * - a country code
     *
     * @param integer|string|Feature $place
     * @throws \InvalidArgumentException
     */
    public function __construct( $place )
    {
        if ( is_integer( $place ) ) {
            $this->geonamesId = $place;
        } elseif ( is_string( $place )  ) {
            $this->countryCode = $place;
        } elseif ( is_object( $place ) && $place instanceof Feature ) {
            $this->geonamesId = $place->getId( );
        } else {
            throw new \InvalidArgumentException(
                'Requires Geonames ID, or an instance of the Feature class'
            );
        }
    }

    /**
     * Get the URI for this query
     *
     * @return string
     */
    public function getUri( )
    {
        return 'neighbours';
    }

    /**
     * Build the query
     *
     * @return array
     */
    public function build( )
    {
        $query = parent::build( );

        if ( $this->geonamesId ) {
            $query[ 'geonameId' ] = $this->geonamesId;
        } else {
            $query[ 'country' ] = $this->countryCode;
        }

        return $query;

    }

}