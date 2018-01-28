<?php

use Lukaswhite\Geonames\Geonames;
use Lukaswhite\Geonames\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Middleware;
use Lukaswhite\Geonames\Query\Get;

class ServiceTest extends PHPUnit_Framework_TestCase{

    public function testIsThereAnySyntaxError( )
    {
        $var = new Geonames( 'user123' );
        $this->assertTrue( is_object( $var ) );
        unset( $var );
    }

    public function testSetUsernameInConfig( )
    {
        $client = new Client( [
            'username'  =>  'user123',
        ] );

        $this->assertAttributeEquals( 'user123', 'username', $client );
    }

    public function testSetUsername( )
    {
        $client = new Client( );
        $client->setUsername( 'user123' );

        $this->assertAttributeEquals( 'user123', 'username', $client );
    }

    private function getClientThatReturns( $filepath )
    {
        $mock = new MockHandler( [
            new Response( 200, [ ], file_get_contents( __DIR__ . $filepath ) ),
        ] );

        $handler = HandlerStack::create( $mock );

        $client = new Client( [
            'handler'   =>  $handler,
        ] );

        return $client;
    }

    public function __testGet( )
    {
        $client = $this->getClientThatReturns( '/fixtures/get/barnet.xml' );

        $service = new Geonames( 'user123', $client );

        $query = new Get( );
        $query->setPlace( 2656295 );

        $place = $service->run( $query );
        $this->assertInstanceOf( \Lukaswhite\Geonames\Models\Feature::class, $place );
        $this->assertEquals( 'Barnet', $place->getName( ) );
    }

    public function testSearch( )
    {
        $client = $this->getClientThatReturns( '/fixtures/search/results.xml' );

        $service = new Geonames( 'user123', $client );

        $query = new \Lukaswhite\Geonames\Query\Search( );
        $query->filterByFeatureClass( 'P' );

        $results = $service->run( $query );
        $this->assertInstanceOf( \Lukaswhite\Geonames\Results\Resultset::class, $results );
        $this->assertEquals( 64250, $results->total( ) );
        $northernEurope = $results->first( );
        $this->assertEquals( 'Northern Europe', $northernEurope->getName( ) );
        $this->assertEquals( 'Northern Europe', $northernEurope->getToponymName( ) );
        $uk = $results->getResults( )[ 1 ];
        $this->assertEquals( 'United Kingdom', $uk->getName( ) );
    }

    /**
     * @expectedException \Lukaswhite\Geonames\Exceptions\AuthException
     * @expectedExceptionMessage Please add a username to each call in order for geonames to be able to identify the calling application and count the credits usage.
     */
    public function ___testUsernameNotProvided( )
    {
        $mock = new MockHandler( [
            new Response( 200, [ ], file_get_contents( __DIR__ . '/fixtures/errors/username-not-provided.xml' ) ),
        ] );

        $handler = HandlerStack::create( $mock );

        $client = new Client( [
            'username'  =>  'user123',
            'handler'   =>  $handler,
        ] );

        $client->lookup( 12345 );
    }

    /**
     * @expectedException \Lukaswhite\Geonames\Exceptions\AuthException
     * @expectedExceptionMessage user does not exist.
     */
    public function ___testUsernameDoesNotExist( )
    {
        $mock = new MockHandler( [
            new Response( 200, [ ], file_get_contents( __DIR__ . '/fixtures/errors/username-does-not-exist.xml' ) ),
        ] );

        $handler = HandlerStack::create( $mock );

        $client = new Client( [
            'username'  =>  'user123',
            'handler'   =>  $handler,
        ] );

        $client->lookup( 12345 );
    }

    /**
     * @expectedException \Lukaswhite\Geonames\Exceptions\MaxRequestsExceededException
     */
    public function ___testMaximumRequestsExceeded( )
    {
        $mock = new MockHandler( [
            new Response( 200, [ ], file_get_contents( __DIR__ . '/fixtures/errors/max-requests-exceeded.xml' ) ),
        ] );

        $handler = HandlerStack::create( $mock );

        $client = new Client( [
            'username'  =>  'user123',
            'handler'   =>  $handler,
        ] );

        $client->lookup( 12345 );
    }

    public function ___testLookup( )
    {
        $mock = new MockHandler( [
            new Response( 200, [ ], file_get_contents( __DIR__ . '/fixtures/get/barnet.xml' ) ),
        ] );

        $handler = HandlerStack::create( $mock );

        $client = new Client( [
            'username'  =>  'user123',
            'handler'   =>  $handler,
        ] );

        $place = $client->lookup( 2656295 );
        $this->assertInstanceOf( \Lukaswhite\Geonames\Models\Feature::class, $place );
        $this->assertEquals( 'Barnet', $place->getName( ) );
    }

    /**
     * @expectedException \Lukaswhite\Geonames\Exceptions\NotFoundException
     * @expectedExceptionMessage this geonameid does not exist
     */
    public function ___testLookupNotFound( )
    {
        $mock = new MockHandler( [
            new Response( 200, [ ], file_get_contents( __DIR__ . '/fixtures/errors/geonameid-does-not-exist.xml' ) ),
        ] );

        $handler = HandlerStack::create( $mock );

        $client = new Client( [
            'username'  =>  'user123',
            'handler'   =>  $handler,
        ] );

        $place = $client->lookup( 1 );
    }

    /**
     * @expectedException \Lukaswhite\Geonames\Exceptions\UnknownErrorException
     * @expectedExceptionMessage some other error
     */
    public function ___testUnknownErrorException( )
    {
        $mock = new MockHandler( [
            new Response( 200, [ ], file_get_contents( __DIR__ . '/fixtures/errors/other-error.xml' ) ),
        ] );

        $handler = HandlerStack::create( $mock );

        $client = new Client( [
            'username'  =>  'user123',
            'handler'   =>  $handler,
        ] );

        $place = $client->lookup( 1 );
    }


    public function ____testMakeRequest( )
    {

        $mock = new MockHandler( [
            new Response( 200, [ ], 'this is a test' ),
        ] );

        $handler = HandlerStack::create( $mock );

        // We use the history middleware so we can inspect the request after we've made it
        $container = [];
        $history = Middleware::history($container);

        $handler->push($history);

        $client = new Client( [
            'handler'   =>  $handler,
        ] );

        $client->setBaseUri( 'https://example.com' );

        $client->setAccessToken( 'secret123' );

        $client->request( 'get', 'api/foobar' );

        $requestMade = $container[ 0 ][ 'request' ];

        $this->assertEquals( 'https', $requestMade->getUri( )->getScheme( ) );
        $this->assertEquals( 'example.com', $requestMade->getUri( )->getHost( ) );
        $this->assertEquals( '/api/foobar', $requestMade->getUri( )->getPath( ) );

        $this->assertTrue( $requestMade->hasHeader( 'Authorization' ) );
        $this->assertEquals( 'Bearer secret123', $requestMade->getHeader( 'Authorization' )[ 0 ] );
    }

    

}