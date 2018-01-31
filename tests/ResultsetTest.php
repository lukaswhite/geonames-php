<?php

use Lukaswhite\Geonames\Models\Feature;

class ResultsetTest extends PHPUnit_Framework_TestCase{

    public function testBasicFeatures( )
    {
        $results = new \Lukaswhite\Geonames\Results\Resultset(
            [ 'one', 'two', 'three' ],
            10
        );

        $this->assertEquals( 3, $results->count( ) );
        $this->assertEquals( 10, $results->total( ) );

        $this->assertInstanceOf( ArrayIterator::class, $results->getIterator( ) );

        $this->assertInternalType( 'array', $results->getResults( ) );
        $this->assertEquals( [ 'one', 'two', 'three' ], $results->getResults( ) );
        $this->assertEquals( [ 'one', 'two', 'three' ], $results->toArray( ) );
    }

    public function testFirstAndLast( )
    {
        $results = new \Lukaswhite\Geonames\Results\Resultset(
            [ 'one', 'two', 'three' ],
            10
        );

        $this->assertEquals( 'one', $results->first( ) );
        $this->assertEquals( 'three', $results->last( ) );

        $empty = new \Lukaswhite\Geonames\Results\Resultset(
            [ ],
            10
        );

        $this->assertNull( $empty->first( ) );
        $this->assertNull( $empty->last( ) );
    }

    public function testArrayAccess( )
    {
        $results = new \Lukaswhite\Geonames\Results\Resultset(
            [ 'one', 'two', 'three' ],
            10
        );

        $this->assertEquals( 'one', $results[ 0 ] );
        $this->assertEquals( 'two', $results[ 1 ] );
        $this->assertEquals( 'three', $results[ 2 ] );

        $this->assertTrue( isset( $results[ 1 ] ) );
        $this->assertFalse( isset( $results[ 3 ] ) );

        $results[ 1 ] = 'bar';
        $this->assertEquals( 'bar', $results[ 1 ] );
        unset( $results[ 1 ] );
        $this->assertFalse( isset( $results[ 1 ] ) );

        unset( $results );

    }

    public function testMap( )
    {
        $results = new \Lukaswhite\Geonames\Results\Resultset( [ 1, 2, 3 ], 3 );
        $incremented = $results->map( function( $item ) {
            return ( $item + 1 );
        } );
        $this->assertInstanceOf( \Lukaswhite\Geonames\Results\Resultset::class, $incremented );
        $this->assertEquals( [ 2, 3, 4 ], $incremented->getResults( ) );
        unset( $results );

        $apple = new stdClass( );
        $apple->name = 'apple';
        $apple->type = 'fruit';

        $orange = new stdClass( );
        $orange->name = 'orange';
        $orange->type = 'fruit';

        $carrot = new stdClass( );
        $carrot->name = 'carrot';
        $carrot->type = 'vegetable';

        $results = new \Lukaswhite\Geonames\Results\Resultset(
            [
                $apple,
                $orange,
                $carrot
            ],
            3
        );

        $this->assertEquals(
            [ 'apple', 'orange', 'carrot' ],
            $results->map( function( $item ) {
                return $item->name;
            } )->getResults( )
        );
    }

}