<?php namespace Lukaswhite\Geonames\Query;

use Lukaswhite\Geonames\Contracts\QueriesService;
use Lukaswhite\Geonames\Models\Feature;
use Lukaswhite\Geonames\Traits\Queries\CanHaveOperator;
use Lukaswhite\Geonames\Traits\Queries\CanSpecifyCharacterSet;
use Lukaswhite\Geonames\Traits\Queries\CanSpecifyLanguage;
use Lukaswhite\Geonames\Traits\Queries\CanSpecifyVerbosity;
use Lukaswhite\Geonames\Traits\Queries\FiltersByCountry;
use Lukaswhite\Geonames\Traits\Queries\FiltersByFeature;
use Lukaswhite\Geonames\Traits\Queries\HasPagination;
use Lukaswhite\Geonames\Models\Country;
use Lukaswhite\Geonames\Models\Continent;
use Lukaswhite\Geonames\Models\Geoname;
use Lukaswhite\Geonames\Traits\Geo\HasBoundingBox;
use Lukaswhite\Geonames\Traits\Queries\SupportsCitiesParameter;

/**
 * Class Search
 *
 * This service allows you to search the Geonames database.
 *
 * Possible use-cases include:
 *
 *  - getting all of the cities and towns in a given country
 *  - searching for places that start with a given letter(s) (think autocomplete)
 *  - finding the most populous places
 *  - finding all of the places within the specified area (i.e. a bounding box)
 *
 * @package Lukaswhite\Geonames\Query
 */
class Search implements QueriesService
{
    use HasBoundingBox,
        FiltersByFeature,
        FiltersByCountry,
        SupportsCitiesParameter,
        CanHaveOperator,
        HasPagination,
        CanSpecifyVerbosity,
        CanSpecifyLanguage,
        CanSpecifyCharacterSet;

    /**
     * The query
     *
     * @var string
     */
    private $q;

    /**
     * The place name
     *
     * @var string
     */
    private $name;

    /**
     * The place name equals clause
     *
     * @var string
     */
    private $nameEquals;

    /**
     * The place name starts with clause
     *
     * @var string
     */
    private $nameStartsWith;

    /**
     * Records from the countryBias are listed first
     *
     * @var string
     */
    private $countryBias;

    /**
     * The continent to restrict the query to
     *
     * @var string
     */
    private $continent;

    /**
     * Code of administrative subdivision (level 1)
     *
     * @var string
     */
    private $admin1Code;

    /**
     * Code of administrative subdivision (level 2)
     *
     * @var string
     */
    private $admin2Code;

    /**
     * Code of administrative subdivision (level 3)
     *
     * @var string
     */
    private $admin3Code;

    /**
     * Search for toponyms tagged with the specified tag
     *
     * @var string
     */
    private $tag;

    /**
     * The sort order
     *
     * @var string
     */
    private $orderBy;

    /**
     * Whether at least one of the search term needs to be part of the place name
     *
     * @var bool
     */
    private $isNameRequired;

    /**
     * Defines the fuzziness of the search terms (float between 0 and 1).
     *
     * @var float
     */
    private $fuzzy;

    /**
     * In combination with the name parameter, the search will only consider names in the specified language.
     * Used for instance to query for IATA airport codes.
     *
     * @var string
     */
    private $searchlang;

    /**
     * Include bounding box info, regardless of style setting.
     *
     * @var bool
     */
    private $inclBbox;

    /**
     * Get the URI for this query
     *
     * @return string
     */
    public function getUri( )
    {
        return 'search';
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
     * Query by the given term
     *
     * @param string $query
     * @return $this
     */
    public function query( $query )
    {
        $this->q = $query;
        return $this;
    }

    /**
     * Query by the given name
     *
     * @param string $name
     * @return $this
     */
    public function name( $name )
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Set the name equals clause
     *
     * @param string $name
     * @return $this
     */
    public function nameEquals( $name )
    {
        $this->nameEquals = $name;
        return $this;
    }

    /**
     * Set the name starts with clause
     *
     * @param string $name
     * @return $this
     */
    public function nameStartswith( $name )
    {
        $this->nameStartsWith = $name;
        return $this;
    }

    /**
     * Indicate that records from a particular country should be listed first.
     *
     * @param Country|string $country
     * @return $this
     */
    public function countryBias( $country )
    {
        if ( is_object( $country ) && $country instanceof \Lukaswhite\Geonames\Models\Country ) {
            $this->countryBias = $country->getCode( );
        } else {
            $this->countryBias = $country;
        }
        return $this;
    }

    /**
     * Limit the query to those results in the specified continent
     *
     * @param string $code
     * @return $this
     */
    public function inContinent( $code )
    {
        if ( ! Continent::isValid( $code ) ) {
            throw new \InvalidArgumentException( 'Invalid continent' );
        }
        $this->continent = $code;
        return $this;
    }

    /**
     * Filter by code of administrative subdivision (level 1)
     *
     * @param string $code
     * @return $this
     */
    public function inAdmin1Code( $code )
    {
        $this->admin1Code = $code;
        return $this;
    }

    /**
     * Filter by code of administrative subdivision (level 2)
     *
     * @param string $code
     * @return $this
     */
    public function inAdmin2Code( $code )
    {
        $this->admin2Code = $code;
        return $this;
    }

    /**
     * Filter by code of administrative subdivision (level 3)
     *
     * @param string $code
     * @return $this
     */
    public function inAdmin3Code( $code )
    {
        $this->admin3Code = $code;
        return $this;
    }

    /**
     * Search in a given place
     *
     * This essentially extracts the relevant admin code, and utilizes that.
     *
     * @param Feature $place
     * @return $this
     *
     * @todo It might be better to set all the admin codes
     */
    public function in( Feature $place )
    {
        switch ( $place->getAdminCodeLevel( ) ) {
            case 3:
                $this->admin3Code = $place->getAdminCode3( );
                break;
            case 2:
                $this->admin2Code = $place->getAdminCode2( );
                break;
            case 1:
                $this->admin1Code = $place->getAdminCode1( );
                break;
        }
        return $this;
    }

    /**
     * Search for toponyms tagged with the specified tag
     *
     * @param string $tag
     * @return $this
     */
    public function taggedWith( $tag )
    {
        $this->tag = $tag;
        return $this;
    }

    /**
     * Specify that at least one of the search term needs to be part of the place name
     *
     * @param bool
     * @return $this;
     */
    public function nameIsRequired( $required = true )
    {
        $this->isNameRequired = $required;
        return $this;
    }

    /**
     * Set the fuzzy value; this defines the fuzziness of the search terms. It should be a float between 0 and 1.
     *
     * @param float $value
     * @return $this
     */
    public function fuzzy( $value )
    {
        if ( $value < 0 || $value > 1 ) {
            throw new \InvalidArgumentException( 'The fuzzy value should be a float betwen 0 and 1' );
        }
        $this->fuzzy = $value;
        return $this;
    }

    /**
     * In combination with the name parameter, the search will only consider names in the specified language.
     *
     * @param string $language
     * @return $this
     */
    public function searchLanguage( $language )
    {
        $this->searchlang = $language;
        return $this;
    }

    /**
     * Indicate that we want to include bounding box info, regardless of the style setting
     *
     * @param bool $include
     * @return $this
     */
    public function includeBoundingBoxInfo( $include = true )
    {
        $this->inclBbox = $include;
        return $this;
    }

    /**
     * Determine the sort order
     *
     * @param string $property
     * @return $this
     */
    public function orderBy( $property )
    {
        if ( ! in_array(
            $property,
            [
                'population',
                'elevation',
                'relevance',
            ]
        ) ) {
            throw new \InvalidArgumentException( 'Invalid order by' );
        }

        $this->orderBy = $property;

        return $this;
    }

    /**
     * Order by population; basically syntactic sugar for orderBy( 'population' )
     *
     * @return $this
     */
    public function orderByPopulation( )
    {
        return $this->orderBy( 'population' );
    }

    /**
     * Order by elevation; basically syntactic sugar for orderBy( 'elevation' )
     *
     * @return $this
     */
    public function orderByElevation( )
    {
        return $this->orderBy( 'elevation' );
    }

    /**
     * Order by relevance; basically syntactic sugar for orderBy( 'relevance' )
     *
     * @return $this
     */
    public function orderByRelevance( )
    {
        return $this->orderBy( 'relevance' );
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

        // Optionally inject the query value
        if ( isset( $this->q ) ) {
            $query[ 'q' ] = urlencode( utf8_encode( $this->q ) );
        }

        // Optionally inject the name
        if ( isset( $this->name ) ) {
            $query[ 'name' ] = urlencode( utf8_encode( $this->name ) );
        }

        // Optionally inject the name equals clause
        if ( isset( $this->nameEquals ) ) {
            $query[ 'name_equals' ] = $this->nameEquals;
        }

        // Optionally inject the name starts with clause
        if ( isset( $this->nameStartsWith ) ) {
            $query[ 'name_startsWith' ] = $this->nameStartsWith;
        }

        // Optionally inject the isNameRequired value
        if ( isset( $this->isNameRequired ) ) {
            $query[ 'isNameRequired' ] = $this->isNameRequired;
        }

        // Optionally inject the fuzzy value
        if ( isset( $this->fuzzy ) ) {
            $query[ 'fuzzy' ] = $this->fuzzy;
        }

        // Optionally add the feature-related filters
        $this->addFeatureFiltersToQuery( $query );

        // Optionally filter by country(ies)
        $this->addCountryFiltersToQuery( $query );

        // Optionally inject the country bias param
        if ( $this->countryBias ) {
            $query[ 'countryBias' ] = $this->countryBias;
        }

        // Optionally filter by continent
        if ( $this->continent ) {
            $query[ 'continentCode' ] = $this->continent;
        }

        // Optionally filter by code of administrative subdivision (1)
        if ( $this->admin1Code ) {
            $query[ 'adminCode1' ] = $this->admin1Code;
        }

        // Optionally filter by code of administrative subdivision (2)
        if ( $this->admin2Code ) {
            $query[ 'adminCode2' ] = $this->admin2Code;
        }

        // Optionally filter by code of administrative subdivision (3)
        if ( $this->admin3Code ) {
            $query[ 'adminCode3' ] = $this->admin3Code;
        }

        // Optionally inject the cities search param
        $this->addCitiesParameterToQuery( $query );

        // Optionally add the tag to the query
        if ( $this->tag ) {
            $query[ 'tag' ] = $this->tag;
        }

        // If the operator has been specified, add that to the query
        $this->addOperatorToQuery( $query );

        // If the query includes a bounding box, then parameterize that and inject it into the query
        if ( $this->boundingBox ) {
            $query += $this->parameterizeBoundingBox( );
        }

        // Optionally specify the language
        $this->addLanguageToQuery( $query );

        // Optionally specify the search language
        if ( $this->searchlang ) {
            $query[ 'searchlang' ] = $this->searchlang;
        }

        // Optionally specify the character set
        $this->addCharacterSetToQuery( $query );

        // Optionally indicate that we want bounding box info regardless of the style setting
        if ( $this->inclBbox ) {
            $query[ 'inclBbox' ] = $this->inclBbox;
        }

        // If the order by has been explicitly specified, add that to the query
        if ( $this->orderBy ) {
            $query[ 'orderby' ] = $this->orderBy;
        }

        // Inject the pagination parameters into the query
        $this->addPagingToQuery( $query );

        // If the style has been explicitly specified, add that to the query
        $this->addStyleToQuery( $query );


        if ( $this->style ) {
            $query[ 'style' ] = $this->style;
        }

        return $query;

    }

}