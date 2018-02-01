<?php namespace Lukaswhite\Geonames\Models;

use Lukaswhite\Geonames\Traits\Models\HasAdminCodes;
use Lukaswhite\Geonames\Traits\Models\HasAdministrativeAreas;
use Lukaswhite\Geonames\Models\Timezone;
use Lukaswhite\Geonames\Contracts\HasAdminCodes as HasAdminCodesContract;
use Lukaswhite\Geonames\Contracts\HasAdminCodeNames as HasAdminCodeNamesContract;
use Lukaswhite\Geonames\Contracts\HasAdministrativeAreas as HasAdministrativeAreasContract;
use Lukaswhite\Geonames\Contracts\HasCoordinates as HasCoordinatesContract;
use Lukaswhite\Geonames\Traits\Geo\HasCoordinates;
use Lukaswhite\Geonames\Traits\Models\HasDistance;
use Lukaswhite\Geonames\Traits\Models\HasGeonamesId;
use Lukaswhite\Geonames\Traits\Models\HasName;
use Lukaswhite\Geonames\Traits\Geo\HasBoundingBox;

/**
 * Class Feature
 *
 * A feature in Geonames is a geographical feature and can be all sorts of things:
 *
 *  - a country or political entity
 *  - a county or state
 *  - a city, town or village
 *  - a river
 *  - a mountain
 *  - a railway station
 *
 * This class encapsulates all of the information contained within the Geonames database.
 *
 * @package Lukaswhite\Geonames\Models
 */
class Feature implements HasAdminCodesContract, HasAdminCodeNamesContract, HasAdministrativeAreasContract, HasCoordinatesContract
{
    use HasGeonamesId,
        HasCoordinates,
        HasBoundingBox,
        HasAdminCodes,
        HasAdministrativeAreas,
        HasName,
        HasDistance;

    /**
     * The toponym name; i.e. the main name of the toponym as displayed on the google maps interface page
     * or in the geoname file in the download
     *
     * @var string
     */
    private $toponymName;

    /**
     * The ascii name
     *
     * @var string
     */
    private $asciiName;

    /**
     * The country
     *
     * @var Country
     */
    private $country;

    /**
     * The Feature class (A,H,L,P,R,S,T,U,V)
     *
     * @var string
     */
    private $fcl;

    /**
     * The feature code
     *
     * @var string
     */
    private $fcode;

    /**
     * The population, if applicable
     *
     * @param int
     */
    private $population;

    /**
     * The elevation, if known
     *
     * @var integer
     */
    private $elevation;

    /**
     * The STRM (Shuttle Radar Topography Mission) elevation
     *
     * @var int
     */
    private $strm3;

    /**
     * The Aster Global Digital Elevation Model V1 elevation
     *
     * @var integer
     */
    private $astergdem;

    /**
     * The alternate country codes
     *
     * @var array
     */
    private $cc2;

    /**
     * The continent code
     *
     * @var string
     */
    private $continentCode;

    /**
     * The alternate names
     *
     * @var array
     */
    private $alternateNames = [ ];

    /**
     * The timezeone
     *
     * @vars Timezone
     */
    private $timezone;

    /**
     * The (relevance) score; this is only applicable when a feature
     * has been obtained as the result of a search
     *
     * @var float
     */
    private $score;

    /**
     * Geoname constructor.
     */
    public function __construct( )
    {

    }

    /**
     * @return string
     */
    public function getToponymName(): string
    {
        return $this->toponymName;
    }

    /**
     * @param string $toponymName
     * @return $this
     */
    public function setToponymName( string $toponymName )
    {
        $this->toponymName = $toponymName;
        return $this;
    }

    /**
     * @return string
     */
    public function getAsciiName()
    {
        return $this->asciiName;
    }

    /**
     * @param string $asciiName
     * @return $this
     */
    public function setAsciiName( $asciiName )
    {
        $this->asciiName = $asciiName;
        return $this;
    }

    /**
     * @return Country
     */
    public function getCountry(): Country
    {
        return $this->country;
    }

    /**
     * @param Country $country
     * @return $this
     */
    public function setCountry( Country $country )
    {
        $this->country = $country;
        return $this;
    }

    /**
     * @return string
     */
    public function getFcl(): string
    {
        return $this->fcl;
    }

    /**
     * @param string $fcl
     * @return $this
     */
    public function setFcl( string $fcl )
    {
        $this->fcl = $fcl;
        return $this;
    }

    /**
     * @return string
     */
    public function getFcode(): string
    {
        return $this->fcode;
    }

    /**
     * @param string $fcode
     * @return $this
     */
    public function setFcode( string $fcode )
    {
        $this->fcode = $fcode;
        return $this;
    }

    /**
     * Returns an instance of the Classification model
     *
     * @return Classification
     */
    public function getClassification( )
    {
        return new Classification(
            $this->fcl,
            $this->fcode
        );
    }

    /**
     * @return int
     */
    public function getPopulation()
    {
        return $this->population;
    }

    /**
     * @param int $population
     * @@return $this
     */
    public function setPopulation( $population )
    {
        $this->population = $population;
        return $this;
    }

    /**
     * @return int
     */
    public function getElevation(): int
    {
        return $this->elevation;
    }

    /**
     * @param int $elevation
     * @return $this
     */
    public function setElevation( int $elevation )
    {
        $this->elevation = $elevation;
        return $this;
    }

    /**
     * @return int
     */
    public function getStrm3(): int
    {
        return $this->strm3;
    }

    /**
     * @param int $strm3
     * @return $this
     */
    public function setStrm3( int $strm3 )
    {
        $this->strm3 = $strm3;
        return $this;
    }

    /**
     * @return int
     */
    public function getAstergdem(): int
    {
        return $this->astergdem;
    }

    /**
     * @param int $astergdem
     * @return $this
     */
    public function setAstergdem( int $astergdem )
    {
        $this->astergdem = $astergdem;
        return $this;
    }

    /**
     * @return string
     */
    public function getCc2(): string
    {
        return $this->cc2;
    }

    /**
     * @param string $cc2
     * @return $this;
     */
    public function setCc2( string $cc2 )
    {
        $this->cc2 = $cc2;
        return $this;
    }

    /**
     * Get the alternate country codes
     *
     * @return array
     */
    public function getAlternateCountryCodes( )
    {
        return ( $this->cc2 ) ? explode( ',', $this->cc2 ) : [ ];
    }

    /**
     * @return array
     */
    public function getAlternateNames(): array
    {
        return $this->alternateNames;
    }

    /**
     * Set the alternate names
     *
     * @param array $alternateNames
     * @return $this
     */
    public function setAlternateNames( array $alternateNames )
    {
        $this->alternateNames = [ ];
        if ( count( $alternateNames ) ) {
            foreach( $alternateNames as $name ) {
                $this->alternateNames[ $name->getLanguage( ) ] = $name;
            }
        }
        return $this;
    }

    /**
     * Add an alternate name
     *
     * @param AlternateName $name
     * @return $this
     */
    public function addAlternateName( AlternateName $name )
    {
        $this->alternateNames[ $name->getLanguage( ) ] = $name;
        return $this;
    }

    /**
     * Get the alternate name, in the specified language.
     *
     * @param string $language
     * @return string|null
     */
    public function getAlternateName( $language )
    {
        return ( isset( $this->alternateNames[ $language ] ) ) ? $this->alternateNames[ $language ] : null;
    }

    /**
     * @return string
     */
    public function getContinentCode(): string
    {
        return $this->continentCode;
    }

    /**
     * @param string $continentCode
     * @return $this
     */
    public function setContinentCode( string $continentCode )
    {
        $this->continentCode = $continentCode;
        return $this;
    }

    /**
     * @return Timezone
     */
    public function getTimezone()
    {
        return $this->timezone;
    }

    /**
     * @param Timezone $timezone
     * @return $this
     */
    public function setTimezone( Timezone $timezone )
    {
        $this->timezone = $timezone;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * @param mixed $score
     * @return Feature
     */
    public function setScore( $score )
    {
        $this->score = $score;
        return $this;
    }

    /**
     * Create an array representation of this feature.
     *
     * @return array
     */
    public function toArray( )
    {
        $arr = [ ];

        if ( $this->id ) {
            $arr[ 'id' ] = $this->id;
        }

        foreach( [
            'name',
            'toponymName',
            'asciiName',
            'fcl',
            'fcode',
        ] as $property ) {
            if ( isset( $this->$property ) && strlen( $this->$property ) ) {
                $arr[ $property ] = $this->$property;
            }
        }

        if ( $this->country ) {
            $arr[ 'country' ] = $this->country->toArray( );
        }

        if ( $this->coordinates ) {
            $arr[ 'latitude' ] = $this->coordinates->getLatitude( );
            $arr[ 'longitude' ] = $this->coordinates->getLongitude( );
        }

        return $arr;
    }

}