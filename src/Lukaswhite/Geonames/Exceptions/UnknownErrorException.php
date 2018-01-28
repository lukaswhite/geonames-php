<?php namespace Lukaswhite\Geonames\Exceptions;

/**
 * Class UnknownErrorException
 *
 * This exception gets thrown if the response is invalid, but we haven't managed to pin-point the cause.
 *
 * It will, however, attempt to inject any error message from Geonames.
 *
 * @package Lukaswhite\Geonames\Exceptions
 */
class UnknownErrorException extends \Exception
{

}