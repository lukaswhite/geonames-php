<?php namespace Lukaswhite\Geonames\Query;

use Lukaswhite\Geonames\Contracts\QueriesService;
use Lukaswhite\Geonames\Models\Feature;
use Lukaswhite\Geonames\Traits\Queries\FiltersByFeature;
use Lukaswhite\Geonames\Traits\Queries\HasPagination;
use Lukaswhite\Geonames\Traits\Queries\CanSpecifyVerbosity;

/**
 * Class Hierarchy
 *
 * @package Lukaswhite\Geonames\Query
 */
class Hierarchy implements QueriesService
{
    use FiltersByFeature,
        HasPagination,
        CanSpecifyVerbosity;

    const CHILDREN      =   'children';
    const HIERARCHY     =   'hierarchy';
    const NEIGHBOURS    =   'neighbours';
    const CONTAINS      =   'contains';
    const SIBLINGS      =   'siblings';

    /**
     * What endpoint we're querying.
     *
     * @var string
     */
    private $endpoint;

    /**
     * The Geonames ID
     *
     * @var int
     */
    private $geonamesId;

    /**
     * The country code
     *
     * @var string
     */
    private $countryCode;

    /**
     * This optional parameter allows to use other hiearchies then the default administrative hierarchy.
     * So far only 'tourism' is implemented.
     *
     * @var string
     */
    private $hierarchyType;

    /**
     * Hierarchy constructor.
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
        return $this->endpoint;
    }

    /**
     * This method declares the type of entity(ies) that this query expects to get in return.
     *
     * @return string
     */
    public function expects( )
    {
        return 'geonames';
    }

    /**
     * Set the place. All hierarchy queries start with a single place.
     *
     * You can provide:
     *
     *  - a Feature object
     *  - a numeric Geonames ID
     *  - a country code
     *
     * @param integer|string|Feature $place
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
     * Specify that we want to get the children of the specified place.
     *
     * @param integer|string|Feature $place
     * @return $this
     */
    public function children( $place )
    {
        $this->setPlace( $place );
        $this->endpoint = self::CHILDREN;
        return $this;
    }

    /**
     * Specify that we want to get the hierarchy for the specified place.
     *
     * @param integer|string|Feature $place
     * @return $this
     */
    public function hierarchy( $place )
    {
        $this->setPlace( $place );
        $this->endpoint = self::HIERARCHY;
        return $this;
    }

    /**
     * Specify that we want to get the neighbours of the specified place.
     *
     * @param integer|string|Feature $place
     * @return $this
     */
    public function neighbours( $place )
    {
        if ( is_string( $place ) ) {
            $this->countryCode = $place;
        } else {
            $this->setPlace( $place );
        }
        $this->endpoint = self::NEIGHBOURS;
        return $this;
    }

    /**
     * Simply an alias of neighbours(), spelt incorrectly for the benefit of our American friends.
     *
     * @param integer|string|Feature $place
     * @return $this
     */
    public function neighbors( $place )
    {
        return $this->neighbours( $place );
    }

    /**
     *  Specify that we want to query features contained within the specified place.
     *
     * @param integer|string|Feature $place
     * @return $this
     */
    public function contains( $place )
    {
        $this->setPlace( $place );
        $this->endpoint = self::CONTAINS;
        return $this;
    }

    /**
     * Specify that we want to get the siblings of the specified place.
     *
     * @param integer|string|Feature $place
     * @return $this
     */
    public function siblings( $place )
    {
        $this->setPlace( $place );
        $this->endpoint = self::SIBLINGS;
        return $this;
    }

    /**
     * Specify that we want a hierarchy query of the specified type.
     *
     * @param $type
     */
    public function ofType( $type )
    {
        $this->hierarchyType = $type;
    }

    /**
     * Build the query
     *
     * @return array
     */
    public function build( )
    {
        $query = [ ];

        if ( $this->endpoint != self::NEIGHBOURS ) {
            $query[ 'geonameId' ] = $this->geonamesId;
        } else {
            // Neighbours query allows a country
            if ( $this->geonamesId ) {
                $query[ 'geonameId' ] = $this->geonamesId;
            } else {
                $query[ 'country' ] = $this->countryCode;
            }
        }

        if ( $this->endpoint == self::CHILDREN ) {
            if ( $this->maxRows ) {
                $query[ 'maxRows' ] = $this->maxRows;
            }
            if ( $this->hierarchyType ) {
                $query[ 'hierarchy' ] = $this->hierarchyType;
            }
        }

        if ( $this->endpoint == self::CONTAINS ) {

            // Optionally filter by feature class(es)
            if ( count( $this->featureClasses ) ) {
                $query[ 'featureClass' ] = $this->featureClasses;
            }

            // Optionally filter by feature class(es)
            if ( count( $this->featureCodes ) ) {
                $query[ 'featureCode' ] = $this->featureCodes;
            }
        }

        // If the style has been explicitly specified, add that to the query
        if ( $this->style ) {
            $query[ 'style' ] = $this->style;
        }

        return $query;

    }

}