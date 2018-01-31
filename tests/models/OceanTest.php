<?php

use Lukaswhite\Geonames\Models\Address;

class OceanTest extends PHPUnit_Framework_TestCase{


    public function testConstructor( )
    {
        $ocean = new \Lukaswhite\Geonames\Models\Ocean( 'North Atlantic Ocean' );
        $this->assertEquals( 'North Atlantic Ocean', $ocean->getName( ) );
    }

    public function testImplementsToStringMethod( )
    {
        $ocean = new \Lukaswhite\Geonames\Models\Ocean( 'North Atlantic Ocean' );
        $this->assertEquals( 'North Atlantic Ocean', $ocean->__toString( ) );
        $this->assertEquals( 'North Atlantic Ocean', ( string ) $ocean );
    }


}