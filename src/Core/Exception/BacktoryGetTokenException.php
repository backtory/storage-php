<?php
namespace Backtory\Storage\Core\Exception;

use Backtory\Storage\Core\Contract\Messages;

/**
 * Class BacktoryGetTokenException
 * @package Backtory\Storage\Core\Exception
 */
class BacktoryGetTokenException extends \Exception
{
    /**
     * @var string
     */
    protected $message = Messages::EXCEPTION_GET_TOKEN;
}