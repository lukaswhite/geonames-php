<?php namespace Lukaswhite\Geonames\Query\Hierarchy;

use Lukaswhite\Geonames\Contracts\QueriesService;

/**
 * Class Siblings
 *
 * @package Lukaswhite\Geonames\Query
 */
class Siblings extends AbstractHierarchy implements QueriesService
{
    /**
     * Get the URI for this query
     *
     * @return string
     */
    public function getUri( )
    {
        return 'siblings';
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