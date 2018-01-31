<?php namespace Lukaswhite\Geonames\Query\Hierarchy;

use Lukaswhite\Geonames\Contracts\QueriesService;
use Lukaswhite\Geonames\Models\Feature;
use Lukaswhite\Geonames\Traits\Queries\CanSpecifyVerbosity;

/**
 * Class AbstractHierarchy
 *
 * @package Lukaswhite\Geonames\Query
 */
abstract class AbstractHierarchy implements QueriesService
{
    use CanSpecifyVerbosity;

    /**
     * The Geonames ID
     *
     * @var int
     */
    protected $geonamesId;

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
     *
     * All hierarchy queries start with a single place.
     *
     * You can provide:
     *
     *  - a Feature object
     *  - a numeric Geonames ID
     *
     * @param integer|string|Feature $place
     * @throws \InvalidArgumentException
     */
    public function __construct( $place )
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
     * Get the URI for this query
     *
     * @return string
     * @codeCoverageIgnore
     */
    public function getUri( )
    {
        return '';
    }

    /**
     * This method declares the type of entity(ies) that this query expects to get in return.
     *
     * @return string
     */
    public function expects( )
    {
        return 'features';
    }

    /**
     * Build the query
     *
     * @return array
     */
    public function build( )
    {
        $query = [ ];

        $this->addStyleToQuery( $query );

        return $query;

    }

}