<?php namespace Lukaswhite\Geonames\Exceptions;

/**
 * Class HttpException
 *
 * This exception gets thrown if there is a problem with the HTTP request.
 *
 * @package Lukaswhite\Geonames\Exceptions
 */
class HttpException extends \Exception
{
    /**
     * The HTTP status code
     *
     * @var integer
     */
    private $httpStatusCode;

    /**
     * HttpException constructor.
     *
     * @param string $message
     * @param int $httpStatusCode
     * @param \Exception|null $previous
     */
    public function __construct( $message, $httpStatusCode, \Exception $previous = null )
    {
        parent::__construct( $message, $httpStatusCode, $previous );
        $this->setHttpStatusCode( $httpStatusCode );
    }

    /**
     * Set the HTTP status code
     *
     * @param integer $code
     */
    public function setHttpStatusCode( $code )
    {
        $this->httpStatusCode = $code;
    }

    /**
     * Get the HTTP status code
     *
     * @return integer
     */
    public function getHttpStatusCode( )
    {
        return $this->httpStatusCode;
    }
}