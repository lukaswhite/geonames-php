<?php namespace Lukaswhite\Geonames\Query;

use Lukaswhite\Geonames\Contracts\QueriesService;
use Lukaswhite\Geonames\Traits\Geo\HasBoundingBox;
use Lukaswhite\Geonames\Traits\Queries\CanHaveOperator;
use Lukaswhite\Geonames\Traits\Queries\CanSpecifyCharacterSet;
use Lukaswhite\Geonames\Traits\Queries\FiltersByCountry;
use Lukaswhite\Geonames\Traits\Queries\HasPagination;
use Lukaswhite\Geonames\Traits\Queries\CanSpecifyVerbosity;

/**
 * Class PostalCodeSearch
 *
 * Returns a list of postal codes and places for the placename/postalcode query as xml document
 * For the US the first returned zip code is determined using zip code area shapes,
 * the following zip codes are based on the centroid.
 * For all other supported countries all returned postal codes are based on centroids.
 *
 * @package Lukaswhite\Geonames\Query
 */
class PostalCodeSearch implements QueriesService
{

    use HasBoundingBox,
        CanHaveOperator,
        HasPagination,
        FiltersByCountry,
        CanSpecifyVerbosity,
        CanSpecifyCharacterSet;

    /**
     * The postal code
     *
     * @var string
     */
    private $postalcode;

    /**
     * The first characters or letters of a postal code
     *
     * @var string
     */
    private $postalcodeStartsWith;

    /**
     * All fields : placename,postal code, country, admin name
     *
     * @var string
     */
    private $placename;

    /**
     * The first characters of a place name
     *
     * @var string
     */
    private $placenameStartsWith;

    /**
     * default is 'false', when set to 'true' only the UK outer codes are returned.
     * Attention: the default value on the commercial servers is currently set to 'true'.
     * It will be changed later to 'false'.
     *
     * @var bool
     */
    private $isReduced;

    /**
     * Get the URI for this query
     *
     * @return string
     */
    public function getUri( )
    {
        return 'postalCodeSearch';
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
     * Search for a given postal code
     *
     * @param string $postalcode
     * @return $this
     */
    public function postalCode( $postalcode )
    {
        $this->postalcode = $postalcode;
        return $this;
    }

    /**
     * Indicate we want postal codes that start with the specified string
     *
     * @param string $str
     * @return $this
     */
    public function postalCodeStartsWith( $str )
    {
        $this->postalcodeStartsWith = $str;
        return $this;
    }

    /**
     * Search for a given place name
     *
     * @param string $placename
     * @return $this
     */
    public function placeName( $placename )
    {
        $this->placename = $placename;
        return $this;
    }

    /**
     * Indicate we want place names that start with the specified string
     *
     * @param string $str
     * @return $this
     */
    public function placeNameStartsWith( $str )
    {
        $this->placenameStartsWith = $str;
        return $this;
    }

    /**
     * @param bool $reduced
     * @return $this
     */
    public function reduced( $reduced = true )
    {
        $this->isReduced = $reduced;
        return $this;
    }

    /**
     * Build the query
     *
     * @return array
     */
    public function build( )
    {
        // Start building an array that represents the query
        $query = [ ];

        // Optionally inject the postal code
        if ( isset( $this->postalcode ) ) {
            $query[ 'postalcode' ] = $this->postalcode;
        }

        // Optionally inject the postal code starts with parameter
        if ( isset( $this->postalcodeStartsWith ) ) {
            $query[ 'postalcode_startsWith' ] = $this->postalcodeStartsWith;
        }

        // Optionally inject the placename
        if ( isset( $this->placename ) ) {
            $query[ 'placename' ] = urlencode( utf8_encode( $this->placename ) );
        }

        // Optionally inject the place name starts with parameter
        if ( isset( $this->placenameStartsWith ) ) {
            $query[ 'placename_startsWith' ] = $this->placenameStartsWith;
        }

        // Optionally inject the isReduced query parameter
        if ( isset( $this->isReduced ) ) {
            $query[ 'isReduced' ] = $this->isReduced;
        }

        // If the query includes a bounding box, then parameterize that and inject it into the query
        if ( $this->boundingBox ) {
            $query += $this->parameterizeBoundingBox( );
        }

        $this->addCountryFiltersToQuery( $query );
        $this->addOperatorToQuery( $query );
        $this->addPagingToQuery( $query );
        $this->addStyleToQuery( $query );
        $this->addCharacterSetToQuery( $query );

        return $query;

    }

}