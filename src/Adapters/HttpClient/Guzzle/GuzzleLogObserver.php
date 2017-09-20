<?php
namespace Backtory\Storage\Adapters\HttpClient\Guzzle;

use GuzzleHttp\HandlerStack;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Namshi\Cuzzle\Middleware\CurlFormatterMiddleware;

/**
 * Class GuzzleLogObserver
 * @package Backtory\Storage\Adapters\HttpClient\Guzzle
 */
class GuzzleLogObserver
{
    public static $LOG_PATH = "";

    /**
     * @return HandlerStack
     */
    public static function getObserver()
    {
        if (empty(self::$LOG_PATH)) {
            return null;
        }

        $logger = new Logger("guzzle");
        $logger->pushHandler(new StreamHandler(self::$LOG_PATH . DIRECTORY_SEPARATOR . "backtory-requests.log"));
        $handler = HandlerStack::create();
        $handler->after('cookies', new CurlFormatterMiddleware($logger));

        return $handler;
    }
}