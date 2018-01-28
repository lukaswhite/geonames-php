<?php namespace Lukaswhite\Geonames\Exceptions;

/**
 * Class InvalidXmlException
 *
 * This exception gets thrown if, for whatever reason, the returned response is not valid XML.
 *
 * @package Lukaswhite\Geonames\Exceptions
 */
class InvalidXmlException extends \Exception
{
    protected $message = 'The XML returned by the web service is invalid';
}