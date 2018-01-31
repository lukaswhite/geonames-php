<?php namespace Lukaswhite\Geonames\Query\ReverseGeocoding;

use Lukaswhite\Geonames\Query\ReverseGeocoding\AbstractReverseGeocoding;
use Lukaswhite\Geonames\Traits\Queries\CanSpecifyLanguage;
use Lukaswhite\Geonames\Traits\Queries\CanSpecifyVerbosity;
use Lukaswhite\Geonames\Traits\Queries\HasPagination;
use Lukaswhite\Geonames\Traits\Queries\SupportsCitiesParameter;

/**
 * Class NearbyPostalCodes
 *
 * A reverse geocoding query to find nearby postal codes.
 *
 * @package Lukaswhite\Geonames\Query
 */
class NearbyPostalCodes extends AbstractReverseGeocoding
{
    use HasPagination,
        SupportsCitiesParameter,
        CanSpecifyLanguage,
        CanSpecifyVerbosity;

    /**
     * Get the URI for this query
     *
     * @return string
     */
    public function getUri( )
    {
        return 'findNearbyPostalCodes';
    }

    /**
     * This method declares the type of entity(ies) that this query expects to get in return.
     *
     * @return string
     */
    public function expects( )
    {
        return 'codes';
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

        $this->addCitiesParameterToQuery( $query );
        $this->addStyleToQuery( $query );
        $this->addLanguageToQuery( $query );
        $this->addPagingToQuery( $query );

        return $query;
    }

}