<?php namespace Lukaswhite\Geonames\Query\Hierarchy;

use Lukaswhite\Geonames\Contracts\QueriesService;

/**
 * Class Hierarchy
 *
 * @package Lukaswhite\Geonames\Query
 */
class Hierarchy extends AbstractHierarchy implements QueriesService
{
    /**
     * Get the URI for this query
     *
     * @return string
     */
    public function getUri( )
    {
        return 'hierarchy';
    }

    /**
     * Build the query
     *
     * @return array
     */
    public function build( )
    {
        $query = parent::build( );

        $query[ 'geonameId' ] = $this->geonamesId;

        return $query;

    }

}