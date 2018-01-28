<?php namespace Lukaswhite\Geonames\Models;

/**
 * Class Continent
 *
 * Represents, as the name implies, a continent.
 *
 * @package Lukaswhite\Geonames\Models
 */
class Continent
{
    /**
     * Geonames uses two-letter codes to represent continents;
     * these constants represent those.
     */
    const AFRICA            =   'AF';
    const ASIA              =   'AS';
    const EUROPE            =   'EU';
    const NORTH_AMERICA     =   'NA';
    const OCEANIA           =   'OC';
    const SOUTH_AMERICA     =   'SA';
    const ANTARCTICA        =   'AN';

    /**
     * Given a code that represents a continent, this method simply
     * checks that it's valid.
     *
     * @param string $code
     * @return bool
     */
    public static function isValid( $code )
    {
       return in_array(
            strtoupper( $code ),
            [
                self::AFRICA,
                self::ASIA,
                self::EUROPE,
                self::NORTH_AMERICA,
                self::OCEANIA,
                self::SOUTH_AMERICA,
                self::ANTARCTICA,
            ]
       );
    }
}