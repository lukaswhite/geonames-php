<?php 

use Lukaswhite\Geonames\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Middleware;

class ClientTest extends PHPUnit_Framework_TestCase{

    public function testIsThereAnySyntaxError( )
    {
        $var = new Client( );
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

    public function testSetBaseUriGetsSetAutomatically( )
    {
        $client = new Client( );

        $this->assertAttributeEquals( 'http://api.geonames.org', 'baseUri', $client );
        $this->assertEquals( 'http://api.geonames.org', $client->getBaseUri( ) );
        $this->assertEquals( 'http', $client->getConfig( 'base_uri' )->getScheme( ) );
        $this->assertEquals( 'api.geonames.org', $client->getConfig( 'base_uri' )->getHost( ) );
    }

    public function testSetBaseUriInConfig( )
    {
        $client = new Client( [
            'base_uri'  =>  'https://example.com',
        ] );

        $this->assertAttributeEquals( 'https://example.com', 'baseUri', $client );
        $this->assertEquals( 'https://example.com', $client->getBaseUri( ) );
        $this->assertEquals( 'https', $client->getConfig( 'base_uri' )->getScheme( ) );
        $this->assertEquals( 'example.com', $client->getConfig( 'base_uri' )->getHost( ) );
    }

    /**
     * @expectedException \Lukaswhite\Geonames\Exceptions\InvalidXmlException
     */
    public function __testInvalidXml( )
    {
        $mock = new MockHandler( [
            new Response( 200, [ ], file_get_contents( __DIR__ . '/fixtures/errors/broken-xml.xml' ) ),
        ] );

        $handler = HandlerStack::create( $mock );

        $client = new Client( [
            'username'  =>  'user123',
            'handler'   =>  $handler,
        ] );

        $client->makeGetRequest( 'get' );
    }



}