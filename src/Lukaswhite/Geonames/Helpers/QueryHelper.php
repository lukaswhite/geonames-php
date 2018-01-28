<?php namespace Lukaswhite\Geonames\Helpers;

/**
 * Class QueryHelper
 *
 * @package Lukaswhite\Geonames\Helpers
 */
class QueryHelper
{
    /**
     * Convert an array into a query string.
     *
     * Some values can be arrays, but they need to repeated like this:
     *
     * featureClass=A&featureClass=P
     *
     * Rather than:
     *
     * featureClass[]=A&featureClass[]=P or featureClass[0]=A&featureClass[1]=P
     *
     * @param array $query
     * @return string
     */
    public function buildQueryString( array $query )
    {
        $pairs = [ ];

        foreach( $query as $key => $value )
        {
            if ( is_array( $value ) ) {
                foreach( $value as $child ) {
                    $pairs[ ] = $this->getKeyValue( $key, $child );
                }
            } else {
                $pairs[ ] = $this->getKeyValue( $key, $value );
            }
        }

        return implode( '&', $pairs );
    }

    /**
     * Get a key/value pair
     *
     * e.g. getKeyValue( 'username', 'demo' ) == 'username=demo'
     *
     * @param $key
     * @param $value
     * @return string
     */
    private function getKeyValue( $key, $value )
    {
        return sprintf(
            '%s=%s',
            urlencode( $key ),
            urlencode( $value )
        );
    }
}