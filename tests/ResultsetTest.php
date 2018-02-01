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

    public function testHasMore( )
    {
        $resultset = new \Lukaswhite\Geonames\Results\Resultset(
            range( 1, 100 ),
            150
        );

        $this->assertTrue( $resultset->hasMore( 0 ) );

        $resultset = new \Lukaswhite\Geonames\Results\Resultset(
            range( 100, 150 ),
            150
        );

        $this->assertFalse( $resultset->hasMore( 100 ) );

        unset( $resultset );

        $resultset = new \Lukaswhite\Geonames\Results\Resultset( range( 1, 100 ) );
        $this->assertFalse( $resultset->hasMore( 0 ) );
    }

    public function testSort( )
    {
        $london = ( new Feature( ) )->setName( 'London' )->setPopulation( 7556900 );
        $edinburgh = ( new Feature( ) )->setName( 'Edinburgh' )->setPopulation( 464990 );
        $leeds = ( new Feature( ) )->setName( 'Leeds' )->setPopulation( 455123 );

        $resultset = new \Lukaswhite\Geonames\Results\Resultset( [ $london, $edinburgh, $leeds ] );
        $resultset->sort( function( Feature $a, Feature $b ) {
            return ( $a->getPopulation( ) <= $b->getPopulation( ) );
        } );

        $this->assertEquals( 'London', $resultset[ 0 ]->getName( ) );
        $this->assertEquals( 'Edinburgh', $resultset[ 1 ]->getName( ) );
        $this->assertEquals( 'Leeds', $resultset[ 2 ]->getName( ) );

        $resultset->sort( function( Feature $a, Feature $b ) {
            return ( $a->getPopulation( ) >= $b->getPopulation( ) );
        } );

        $this->assertEquals( 'Leeds', $resultset[ 0 ]->getName( ) );
        $this->assertEquals( 'Edinburgh', $resultset[ 1 ]->getName( ) );
        $this->assertEquals( 'London', $resultset[ 2 ]->getName( ) );
    }

    public function testFilter( )
    {
        $london = ( new Feature( ) )->setName( 'London' )->setPopulation( 7556900 );
        $edinburgh = ( new Feature( ) )->setName( 'Edinburgh' )->setPopulation( 464990 );
        $leeds = ( new Feature( ) )->setName( 'Leeds' )->setPopulation( 455123 );

        $resultset = new \Lukaswhite\Geonames\Results\Resultset( [ $london, $edinburgh, $leeds ] );

        $large = $resultset->filter( function ( Feature $feature ) {
            return ( $feature->getPopulation( ) > 460000 );
        } );

        $this->assertEquals( 2, $large->count( ) );
        $this->assertEquals( 'London', $resultset[ 0 ]->getName( ) );
        $this->assertEquals( 'Edinburgh', $resultset[ 1 ]->getName( ) );
    }

    public function testFind( )
    {
        $london = ( new Feature( ) )->setId(  2643743)->setName( 'London' )->setPopulation( 7556900 );
        $edinburgh = ( new Feature( ) )->setId( 2650225 )->setName( 'Edinburgh' )->setPopulation( 464990 );
        $leeds = ( new Feature( ) )->setId( 2644688 )->setName( 'Leeds' )->setPopulation( 2644688 );

        $resultset = new \Lukaswhite\Geonames\Results\Resultset( [ $london, $edinburgh, $leeds ] );

        $id = 2650225;

        $sought = $resultset->find( function( Feature $feature ) use ( $id ) {
            return ( $feature->getId( ) == $id );
        } );

        $this->assertInstanceOf( Feature::class, $sought );
        $this->assertEquals( 'Edinburgh', $sought->getName( ) );

        $nonExistentId = 123;

        $this->assertNull( $resultset->find( function( Feature $feature ) use ( $nonExistentId ) {
            return ( $feature->getId( ) == $nonExistentId );
        } ) );
    }


}