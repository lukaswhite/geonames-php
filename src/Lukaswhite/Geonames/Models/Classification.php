<?php namespace Lukaswhite\Geonames\Models;

/**
 * Class Classification
 *
 * This class helps to distinguish different types of entities in the Geonames database.
 *
 * E.g. countries, regions, towns, villages, railway stations, mountains, streams....
 *
 * It encapsulates both the Feature Class and the Feature Code.
 *
 * http://www.geonames.org/export/codes.html
 *
 * @package Lukaswhite\Geonames\Models
 */
class Classification
{
    /**
     * Class constants that represent the various classes.
     */
    const COUNTRY_STATE_REGION  =   'A';
    const STREAM_LAKE           =   'H';
    const PARKS_AREA            =   'L';
    const CITY_VILLAGE          =   'P';
    const ROAD_RAILROAD         =   'R';
    const SPOT_BUILDING_FARM    =   'S';
    const MOUNTAIN_HILL_ROCK    =   'T';
    const UNDERSEA              =   'U';
    const FOREST_HEATH          =   'V';

    /**
     * The feature class is the top-level classification, represented by a single letter.
     *
     * @var string
     */
    private $class;

    /**
     * The feature code further describes a Geonames entity.
     *
     * @var string
     */
    private $code;

    /**
     * Feature constructor.
     * @param string $class
     * @param string $code
     */
    public function __construct( $class, $code = null )
    {
        $this->class = $class;
        $this->code = $code;
    }

    /**
     * @return string
     */
    public function getClass( ): string
    {
        return $this->class;
    }

    /**
     * @param string $class
     * @return $this
     */
    public function setClass( string $class )
    {
        $this->class = $class;
        return $this;
    }

    /**
     * @return string
     */
    public function getCode( )
    {
        return $this->code;
    }

    /**
     * @param string $code
     * @return $this
     */
    public function setCode( string $code )
    {
        $this->code = $code;
        return $this;
    }


}