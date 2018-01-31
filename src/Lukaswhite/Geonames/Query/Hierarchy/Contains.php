<?php namespace Lukaswhite\Geonames\Query\Hierarchy;

use Lukaswhite\Geonames\Contracts\QueriesService;
use Lukaswhite\Geonames\Traits\Queries\FiltersByFeature;

/**
 * Class Contains
 *
 * @package Lukaswhite\Geonames\Query
 */
class Contains extends AbstractHierarchy implements QueriesService
{
    use FiltersByFeature;

    /**
     * Get the URI for this query
     *
     * @return string
     */
    public function getUri( )
    {
        return 'contains';
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

        $this->addFeatureFiltersToQuery( $query );

        return $query;

    }

}