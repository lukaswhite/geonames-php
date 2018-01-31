<?php namespace Lukaswhite\Geonames\Query\Hierarchy;

use Lukaswhite\Geonames\Contracts\QueriesService;
use Lukaswhite\Geonames\Traits\Queries\HasPagination;

/**
 * Class Children
 *
 * @package Lukaswhite\Geonames\Query
 */
class Children extends AbstractHierarchy implements QueriesService
{
    use HasPagination;

    /**
     * This optional parameter allows to use other hiearchies then the default administrative hierarchy.
     * So far only 'tourism' is implemented.
     *
     * @var string
     */
    private $hierarchyType;

    /**
     * Get the URI for this query
     *
     * @return string
     */
    public function getUri( )
    {
        return 'children';
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
        $query = parent::build( );

        $query[ 'geonameId' ] = $this->geonamesId;

        if ( $this->hierarchyType ) {
            $query[ 'hierarchy' ] = $this->hierarchyType;
        }

        $this->addPagingToQuery( $query );

        return $query;

    }

}