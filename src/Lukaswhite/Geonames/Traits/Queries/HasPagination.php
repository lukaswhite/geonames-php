<?php namespace Lukaswhite\Geonames\Traits\Queries;

/**
 * Trait HasPagination
 *
 * This trait indicates that a query type supports pagination
 *
 * @package Lukaswhite\Geonames\Traits\Queries
 */
trait HasPagination
{
    /**
     * The maximum number of rows to return
     *
     * @var integer
     */
    private $maxRows;

    /**
     * The row to start at; this is used for paging the results
     *
     * @var integer
     */
    private $startRow;

    /**
     * Set the limit (i.e. maximum number of rows)
     *
     * @var integer $rows
     * @return $this
     */
    public function limit( $rows )
    {
        $this->maxRows = $rows;
        return $this;
    }

    /**
     * Set the row to start at
     *
     * @param integer $row
     * @return $this
     */
    public function startAtRow( $row )
    {
        $this->startRow = $row;
        return $this;
    }

    /**
     * Inject the pagination parameters into the query
     *
     * @param array $query
     */
    public function addPagingToQuery( & $query )
    {
        // If the maximum number of rows have been explicitly specified, add that to the query
        if ( $this->maxRows ) {
            $query[ 'maxRows' ] = $this->maxRows;
        }

        // If the start row has been explicitly specified, add that to the query
        if ( $this->startRow && $this->startRow > 0 ) {
            $query[ 'startRow' ] = $this->startRow;
        }
    }

    /**
     * Get the offset (i.e. the start row)
     *
     * This is used to aid the pagination of search results.
     *
     * e.g.
     *    if ( $results->hasMore( $query->getOffset( ) ) {
     *       // load more
     *    }
     *
     * @return integer
     */
    public function getOffset( )
    {
        return ( isset( $this->startRow ) ? $this->startRow : 0 );
    }

    /**
     * Get the next offset
     *
     * This is simply the current offset plus the number of rows.
     *
     * e.g.
     *    if ( $results->hasMore( $query->getOffset( ) ) {
     *       $query->startAtRow( $query->getNextOffset( ) );
     *       // load more
     *    }
     *
     * @return integer
     */
    public function getNextOffset( )
    {
        return ( $this->startRow + $this->maxRows );
    }

    /**
     * Modify this query to get the next "page" of results.
     *
     * e.g.
     *    if ( $results->hasMore( $query->getOffset( ) ) {
     *       $query->nextPage( );
     *       // load more
     *    }
     *
     * @return $this
     */
    public function nextPage( )
    {
        $this->startAtRow( $this->getNextOffset( ) );
        return $this;
    }

}