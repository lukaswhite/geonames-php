<?php namespace Lukaswhite\Geonames\Models;

/**
 * Class AlternateName
 *
 * Represents an alternate name of a place, i.e. in a language other than theone requested.
 *
 * @package Lukaswhite\Geonames\Models
 */
class AlternateName
{
    /**
     * The language
     *
     * @var string
     */
    private $language;

    /**
     * The actual name
     *
     * @var string
     */
    private $name;

    /**
     * This helps distinguish between several alternate names in the same language.
     * It marks the most commonly used name
     *
     * @var boolean
     */
    private $isPreferredName = false;

    /**
     * This helps distinguish between several alternate names in the same language.
     * It marks the most commonly used name
     *
     * @var boolean
     */
    private $isShortName = false;

    /**
     * AlternateName constructor.
     *
     * @param string $language
     * @param string $name
     * @param bool $isPreferredName
     */
    public function __construct( $language, $name, $isPreferredName = false, $isShortName = false )
    {
        $this->language = $language;
        $this->name = $name;
        $this->isPreferredName = $isPreferredName;
        $this->isShortName = $isShortName;
    }

    /**
     * Get the language
     *
     * @return string
     */
    public function getLanguage( ): string
    {
        return $this->language;
    }

    /**
     * Get the name
     *
     * @return string
     */
    public function getName( ): string
    {
        return $this->name;
    }

    /**
     * Determine whether this is the most commonly used name
     *
     * @return boolean
     */
    public function isPreferred( )
    {
        return $this->isPreferredName;
    }

    /**
     * Determine whether this is the short form of a name.
     *
     * e.g. lian name 'San Gallo' is the short form of 'Cantone di San Gallo'.
     *
     * @return boolean
     */
    public function isShort( )
    {
        return $this->isShortName;
    }

    /**
     * Determine whether this is a link
     *
     * @return boolean
     */
    public function isLink( )
    {
        return ( $this->language == 'link' );
    }

    /**
     * Determine whether this is an abbreviation
     *
     * @return boolean
     */
    public function isAbbreviation( )
    {
        return ( $this->language == 'abbr' );
    }

    /**
     * Determine whether this is a pseudo language code
     * Pseudo codes:
     * ‘post‘ for postal codes
     * ‘link‘ for a link to a website, in particular links to the English wikipedia article, but also links to
     * other languages in wikipedia or to other websites about the toponym.
     * ‘iata‘, ‘icao‘ and ‘faac‘ for the respective airport codes
     * ‘abbr‘ for an abbreviation
     * ‘fr_1793‘ for names used during the French Revolution
     */
    public function isPseudoLanguage( )
    {
        return in_array(
            $this->language,
            [
                'post',
                'link',
                'iata',
                'icao',
                'faac',
                'abbr',
                'fr_1793'
            ]
        );
    }

    /**
     * Create a string representation of this alternate name; simply returns the actual name.
     *
     * @return string
     */
    public function __toString( )
    {
        return $this->name;
    }

}