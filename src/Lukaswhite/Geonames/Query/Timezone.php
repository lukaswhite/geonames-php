<?php namespace Lukaswhite\Geonames\Query;

use Lukaswhite\Geonames\Contracts\QueriesService;
use Lukaswhite\Geonames\Traits\Geo\HasBoundingBox;
use Lukaswhite\Geonames\Traits\Queries\CanHaveOperator;
use Lukaswhite\Geonames\Traits\Queries\CanSpecifyCharacterSet;
use Lukaswhite\Geonames\Traits\Queries\CanSpecifyLanguage;
use Lukaswhite\Geonames\Traits\Queries\FiltersByCountry;
use Lukaswhite\Geonames\Traits\Queries\HasCoordinates;
use Lukaswhite\Geonames\Traits\Queries\HasPagination;
use Lukaswhite\Geonames\Traits\Queries\CanSpecifyVerbosity;
use Lukaswhite\Geonames\Traits\Queries\HasRadius;

/**
 * Class Timezone
 *
 * Implements the timezone query endpoint. Put simply, it allows you to determine the timezone at a
 * given set of lat/lng co-ordinates.
 *
 * @package Lukaswhite\Geonames\Query
 */
class Timezone implements QueriesService
{
    use HasCoordinates,
        HasRadius,
        CanSpecifyLanguage;

    /**
     * Get the URI for this query
     *
     * @return string
     */
    public function getUri( )
    {
        return 'timezone';
    }

    /**
     * This method declares the type of entity(ies) that this query expects to get in return.
     *
     * @return string
     */
    public function expects( )
    {
        return 'timezone';
    }

    /**
     * The date
     *
     * @var string
     */
    private $date;

    /**
     * Query on the date
     *
     * @param string $date
     * @return $this
     */
    public function onDate( $date )
    {
        $this->date = $date;
        return $this;
    }

    /**
     * Build the query
     *
     * @return array
     */
    public function build( )
    {
        $query = [ ];

        if ( $this->date ) {
            $query[ 'date' ] = $this->date;
        }

        $this->addCoordinatesToQuery( $query );
        $this->addRadiusToQuery( $query );
        $this->addLanguageToQuery( $query );

        return $query;

    }

}