<?php namespace Lukaswhite\Geonames;

use Lukaswhite\Geonames\Helpers\QueryHelper;
use Lukaswhite\Geonames\Mappers\Xml;
use Lukaswhite\Geonames\Query\Search;
use GuzzleHttp\Client as BaseClient;

/**
 * Class Client
 *
 * The web service client
 *
 * @package Lukaswhite\Geonames
 */
class Client extends BaseClient
{
    /**
     * The base Uri to the web service
     *
     * @var string
     */
    protected $baseUri = 'http://api.geonames.org';

    /**
     * The username
     *
     * @var string
     */
    private $username;

    /**
     * The query helper
     *
     * @var QueryHelper
     */
    private $queryHelper;

    /**
     * Client constructor.
     *
     * @param array $config
     */
    public function __construct( array $config = [ ] )
    {
        // Inject the base URI in whilst creating a instance
        parent::__construct(
            $config + [
                'base_uri'  =>  $this->baseUri
            ]
        );

        // If the username has been provided in config, set it now.
        if ( isset( $config[ 'username' ] ) ) {
            $this->username = $config[ 'username' ];
        }

        // Create an instance of the query helper
        $this->queryHelper = new QueryHelper( );
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
        return $this;
    }

    /**
     * Make a request
     *
     * @param string $method
     * @param string $uri
     * @param array $options
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    public function request( $method, $uri = '', array $options = [ ] )
    {
//var_dump( $options );exit();
    //var_dump( $uri );
        //var_dump( $this->buildUri( $uri ) );exit();

        return parent::request(
            $method,
            //$this->buildUri( $uri ),
            $uri,
            $options
        );
    }

    /**
     * Make a GET request to the Geonames API
     *
     * @param string $uri
     * @param array $query
     * @return string
     */
    public function makeGetRequest( $uri, array $query = [ ])
    {
        $query = $this->queryHelper->buildQueryString( $query );

        //var_dump( $query );exit();

        $response = $this->request(
            'GET',
            $uri,
            [
                'query' =>  $query,
            ]
        );

        //var_dump( ( string ) $response->getBody( ) );

        $xml = simplexml_load_string( ( string ) $response->getBody( ) );

        return ( string ) $response->getBody( );
    }

    /**
     * Look up a place / feature by its ID
     *
     * (Note: this corresponds to the get endpoint)
     *
     * @link http://www.geonames.org/export/web-services.html#get
     *
     * @param $id
     * @return Models\Feature
     */
    public function lookup( $id )
    {
        $response = $this->makeGetRequest(
            'get',
            [
                'geonameId' =>  $id,
            ]
        );

        $geoname = Xml::geoname( $this->parseXmlResponse( $response ) );

        return $geoname;
    }

    /**
     * Excute a search
     *
     * @param Search $search
     * @return Results\Resultset
     */
    public function search( Search $search )
    {
        $xml = $this->makeGetRequest(
            'search',
            $search->build( )
        );

        var_dump( $search->build( ) );

        //var_dump( $xml );

        $results = Xml::geonames( $xml );

        return $results;
    }



}