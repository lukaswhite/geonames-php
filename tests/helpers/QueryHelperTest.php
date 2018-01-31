<?php

use Lukaswhite\Geonames\Helpers\QueryHelper;

class QueryHelperTest extends PHPUnit_Framework_TestCase{

    public function testBuildQueryStringSingleLevel( )
    {
        $helper = new QueryHelper( );
        $query = $helper->buildQueryString( [
            'a' =>  1,
            'b' =>  2,
            'c' =>  3,
        ] );

        $this->assertEquals( 'a=1&b=2&c=3', $query );
    }

    public function testBuildQueryStringTwoLevels( )
    {
        $helper = new QueryHelper( );
        $query = $helper->buildQueryString( [
            'a' =>  1,
            'b' =>  [
                2,
                3,
                'foo',
            ],
            'c' =>  3,
        ] );

        $this->assertEquals( 'a=1&b=2&b=3&b=foo&c=3', $query );
    }

    public function testBuildEmpty( )
    {
        $helper = new QueryHelper( );
        $query = $helper->buildQueryString( [ ] );

        $this->assertEquals( '', $query );
    }

}