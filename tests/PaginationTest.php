<?php

class PaginationTest extends PHPUnit_Framework_TestCase{

    public function testOffsets( )
    {
        $query = new DummyQuery( );
        $query->limit( 100 );

        $resultset = new \Lukaswhite\Geonames\Results\Resultset(
            range( 1, 100 ),
            150
        );

        $this->assertTrue( $resultset->hasMore( $query->getOffset( ) ) );
        $this->assertEquals( 0, $query->getOffset( ) );

        $query->nextPage( );
        $this->assertEquals( 100, $query->getOffset( ) );

        $this->assertFalse( $resultset->hasMore( $query->getOffset( ) ) );
    }

}

class DummyQuery {
    use \Lukaswhite\Geonames\Traits\Queries\HasPagination;
}