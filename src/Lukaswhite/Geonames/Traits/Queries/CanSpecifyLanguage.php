<?php namespace Lukaswhite\Geonames\Traits\Queries;

/**
 * Class CanSpecifyLanguage
 *
 * This trait indicates that a query type allows the language to be explictly requested.
 *
 * @package Lukaswhite\Geonames\Traits\Queries
 */
trait CanSpecifyLanguage
{
    /**
     * The place name and country name will be returned in the specified language.
     *
     * @var string
     */
    private $lang;

    /**
     * Specify that the place name and country name should be returned in the specified language.
     *
     * @param string $language
     * @return $this
     */
    public function language( $language )
    {
        $this->lang = $language;
        return $this;
    }

    /**
     * Optionally specify the character set
     *
     * @param $query
     */
    public function addLanguageToQuery( & $query )
    {
        if ( $this->lang ) {
            $query[ 'lang' ] = $this->lang;
        }
    }

}