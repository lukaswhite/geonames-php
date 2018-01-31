<?php namespace Lukaswhite\Geonames\Query\ReverseGeocoding;

use Lukaswhite\Geonames\Query\ReverseGeocoding\AbstractReverseGeocoding;
use Lukaswhite\Geonames\Traits\Queries\CanSpecifyLanguage;
use Lukaswhite\Geonames\Traits\Queries\CanSpecifyVerbosity;
use Lukaswhite\Geonames\Traits\Queries\FiltersByFeature;
use Lukaswhite\Geonames\Traits\Queries\HasPagination;
use Lukaswhite\Geonames\Traits\Queries\SupportsCitiesParameter;

/**
 * Class FindNearby
 *
 * A reverse geocoding query to find nearby toponym
 *
 * @package Lukaswhite\Geonames\Query
 */
class FindNearby extends AbstractReverseGeocoding
{
    use HasPagination,
        FiltersByFeature,
        CanSpecifyVerbosity;

    /**
     * Get the URI for this query
     *
     * @return string
     */
    public function getUri( )
    {
        return 'findNearby';
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
     * In border areas this parameter will restrict the search on the local country
     *
     * @var bool
     */
    private $localCountry;

    /**
     * Restrict the query to the local country
     *
     * @param bool $localCountry
     */
    public function justLocalCountry( $localCountry = true )
    {
        $this->localCountry = $localCountry;
    }

    /**
     * Build the query
     *
     * @return array
     */
    public function build( )
    {
        $query = parent::build( );

        if ( $this->localCountry ) {
            $query[ 'localCountry' ] = $this->localCountry;
        }

        $this->addFeatureFiltersToQuery( $query );
        $this->addStyleToQuery( $query );
        $this->addPagingToQuery( $query );

        return $query;
    }

}