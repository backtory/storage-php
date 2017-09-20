<?php
namespace Backtory\Storage\Core\Exception;

use Backtory\Storage\Core\Contract\Messages;

/**
 * Class BacktoryConfigurationNotSetException
 * @package Backtory\Storage\Core\Exception
 */
class BacktoryConfigurationNotSetException extends BacktoryException
{
    /**
     * @var string
     */
    protected $message = Messages::EXCEPTION_CONFIGURATION_NOT_SET;
}