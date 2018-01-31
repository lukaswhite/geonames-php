# Advanced Usage

## Logging

Sometimes it can help to see what's going on behind the scenes. Notably:

1. To see the URL being called behind the scenes
2. To inspect the raw results

To do this, simply call `setLogger( )`, passing it a logging mechanism that implements the [PSR-3](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-3-logger-interface.md).

Here's an example using the [Monolog](https://github.com/Seldaek/monolog) library:

```php
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

// create a log channel
$log = new Logger('name');
$log->pushHandler(new StreamHandler('path/to/your.log', Logger::WARNING));

$service = new Geonames( getenv( 'GEONAMES_USERNAME' ) );
$service->setLogger( $log );
```

Any URL called by the service will be logged at level `INFO`.

The raw results will be logged at `DEBUG` level.

## Setting the Client

Internally the service uses an extended instance of the [Guzzle](docs.guzzlephp.org) client. 

You're free to extend this, or create an instance and then modify it; simply supply it as the second parameter in the constructor:

```php
$service = new Geonames( getenv( 'GEONAMES_USERNAME' ), $client );
```