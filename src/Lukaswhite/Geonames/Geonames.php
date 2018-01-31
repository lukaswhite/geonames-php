<?php namespace Lukaswhite\Geonames;

use Lukaswhite\Geonames\Contracts\QueriesService;
use Lukaswhite\Geonames\Exceptions\HttpException;
use Lukaswhite\Geonames\Helpers\QueryHelper;
use Lukaswhite\Geonames\Mappers\Xml;
use Lukaswhite\Geonames\Models\Feature;
use Lukaswhite\Geonames\Query\Get;
use Lukaswhite\Geonames\Query\Search;
use Lukaswhite\Geonames\Exceptions\AuthException;
use Lukaswhite\Geonames\Exceptions\InvalidXmlException;
use Lukaswhite\Geonames\Exceptions\MaxRequestsExceededException;
use Lukaswhite\Geonames\Exceptions\NotFoundException;
use Lukaswhite\Geonames\Exceptions\UnknownErrorException;
use Lukaswhite\Geonames\Exceptions\InvalidParameterException;
use GuzzleHttp\Exception\RequestException;
use Psr\Log\LoggerInterface;

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
     * The data mapper
     *
     * @var Xml
     */
    private $mapper;

    /**
     * The logger
     *
     * @var LoggerInterface
     */
    private $logger;

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

        $this->mapper = new \Lukaswhite\Geonames\Mappers\Xml( );
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

    /**
     * Set the logger
     *
     * @param LoggerInterface $logger
     * @return $this
     */
    public function setLogger( LoggerInterface $logger )
    {
        $this->logger = $logger;
    }

    /**
     * Run a query
     *
     * @param QueriesService $query
     * @return Models\Feature|Models\PostalCode|Models\Timezone|Models\Ocean|Models\Neighbourhood|Results\Resultset|string
     *
     * @throws HttpException
     */
    public function run( QueriesService $query )
    {
        // Build the query parameter
        $parameters = $query->build( ) + [
            'username' => $this->username,
        ];

        // Build the full URL that's going to get called, for logging purposes
        $fullUrl = sprintf(
            '%s/%s?%s',
            $this->client->getBaseUri( ),
            $query->getUri( ),
            ( new QueryHelper( ) )->buildQueryString( $parameters )
        );

        var_dump( $fullUrl );

        // If a logger has been set, log the URL being called
        if ( $this->logger ) {
            $this->logger->info( $fullUrl );
        }

        // Now make the query
        try {
            $response = $this->client->makeGetRequest(
                $query->getUri( ),
                $parameters
            );
        } catch ( RequestException $e ) {
            throw new HttpException(
                $e->getMessage( ),
                $e->getResponse( )->getStatusCode( )
            );
        }

        // If a logger has been set, log the response
        if ( $this->logger ) {
            $this->logger->debug( $response );
        }

        // If the query expects a string, then just return that now
        if ( $query->expects( ) == 'string' ) {
            return trim( $response );
        }

        // Parse the response
        $xml = $this->parseXmlResponse( $response );

        // Now map the response XML to the appropriate result type
        switch( $query->expects( ) ) {
            case 'feature':
                return $this->mapper->mapFeature( $xml );
            case 'features':
                return $this->mapper->mapFeatures( $xml );
            case 'countries':
                return $this->mapper->mapCountries( $xml );
            case 'codes':
                return $this->mapper->mapPostalCodes( $xml );
            case 'country-subdivsions':
                return $this->mapper->mapCountrySubdivisions( $xml );
            case 'timezone':
                return $this->mapper->mapTimezone( $xml->timezone[ 0 ] );
            case 'ocean':
                return $this->mapper->mapOcean( $xml );
            case 'neighbourhood':
                return $this->mapper->mapNeighbourhood( $xml->neighbourhood[ 0 ] );
            default:
                throw new \RuntimeException( 'Unsupported response' );
        }

    }

    /**
     * Get a feature by its Geonames ID.
     *
     * This is essentially just a shortcut to creating a Get query and passing that.
     *
     * @param integer|Feature $place
     * @return Feature
     */
    public function get( $place )
    {
        return $this->run( new Get( $place ) );
    }

    /**
     * Parse an XML response
     *
     * @param string $response
     * @return \SimpleXMLElement
     *
     * @throws InvalidXmlException
     * @throws AuthException
     * @throws NotFoundException
     * @throws MaxRequestsExceededException
     * @throws InvalidParameterException
     * @throws UnknownErrorException
     */
    public function parseXmlResponse( $response )
    {
        libxml_use_internal_errors( TRUE );
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
                case 24:
                    throw new InvalidParameterException( $error );
                default:
                    throw new UnknownErrorException( $error );
            }
        }

        return $xml;

    }

}