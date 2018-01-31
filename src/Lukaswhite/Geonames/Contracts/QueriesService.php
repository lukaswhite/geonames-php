<?php namespace Lukaswhite\Geonames\Contracts;

/**
 * Interface QueriesService
 *
 * @package Lukaswhite\Geonames\Contracts
 */
interface QueriesService
{
    /**
     * Get the URI for this query
     *
     * @return string
     */
    public function getUri( );

    /**
     * Build this query
     *
     * @return array
     */
    public function build( );

    /**
     * This is used to declare what sort of data this query expects to receive.
     *
     * E.g. features, codes, countries
     *
     * @return string
     */
    public function expects( );
}