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