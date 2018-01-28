<?php namespace Lukaswhite\Geonames;

use Lukaswhite\Geonames\Contracts\QueriesService;
use Lukaswhite\Geonames\Mappers\Xml;
use Lukaswhite\Geonames\Query\Search;
use Lukaswhite\Geonames\Exceptions\AuthException;
use Lukaswhite\Geonames\Exceptions\InvalidXmlException;
use Lukaswhite\Geonames\Exceptions\MaxRequestsExceededException;
use Lukaswhite\Geonames\Exceptions\NotFoundException;
use Lukaswhite\Geonames\Exceptions\UnknownErrorException;

/**
 * Class Geonames
 *
 * This is the main Geonames class
 *
 * @package Lukaswhite\Geonames
 */
class Geonames
{
    /**
     * The web service username
     *
     * @var string
     */
    private $username;

    /**
     * The Web service client
     *
     * @var Client
     */
    private $client;

    /**
     * Geonames constructor.
     *
     * @param string $username
     */
    public function __construct( $username, $client = null )
    {
        $this->username = $username;
        if ( $client ) {
            $this->client = $client;
        } else {
            $this->client = new Client( );
        }
    }

    /**
     * Set the username
     *
     * @param string $username
     * @return $this
     */
    public function setUsername( $username )
    {
        $this->username = $username;
    }

    public function get( QueriesService $query )
    {
        $response = $this->client->makeGetRequest(
            $query->getUri( ),
            $query->build( ) + [
                'username'  =>  $this->username,
            ]
        );

        $xml = $this->parseXmlResponse( $response );

        return Xml::geoname( $xml );

        //return $xml;
    }

    public function run( QueriesService $query )
    {
        $response = $this->client->makeGetRequest(
            $query->getUri( ),
            $query->build( ) + [
                'username'  =>  $this->username,
            ]
        );

        //var_dump( $response );

        $xml = $this->parseXmlResponse( $response );

        //var_dump( $xml );

        switch( $query->expects( ) ) {
            case 'geoname':
                return Xml::geoname( $xml );
            case 'geonames':
                return Xml::geonames( $xml );
            case 'code':
                return Xml::code( $xml );
            case 'codes':
                return Xml::codes( $xml );
        }
    }

    /**
     * Parse an XML response
     *
     * @param string $response
     * @return \SimpleXMLElement
     * @throws InvalidXmlException
     */
    public function parseXmlResponse( $response )
    {
        libxml_use_internal_errors(TRUE); // this turns off spitting errors on your screen
        try {
            $xml = new \SimpleXMLElement( $response );
        } catch ( \Exception $e ) {
            throw new InvalidXmlException( $e->getMessage( ) );
        }

        // Now check for errors
        if ( $xml->status ) {
            $code = ( int ) $xml->status->attributes( )->value;
            $error = ( string ) $xml->status->attributes( )->message;
            switch ( $code ) {
                case 10:
                    throw new AuthException( $error );
                case 15:
                    throw new NotFoundException( $error );
                case 19:
                    throw new MaxRequestsExceededException( $error );
                default:
                    throw new UnknownErrorException( $error );
            }
        }

        return $xml;

    }

    /**
     * Create a new search
     *
     * @return Search
     */
    public function ___search( )
    {
        return new Search( );
    }


}