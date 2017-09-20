<?php
namespace Backtory\Storage\Core\Exception;

use Backtory\Storage\Core\Contract\Messages;

/**
 * Class BacktoryInvalidConfigFileException
 * @package Backtory\Storage\Core\Exception
 */
class BacktoryInvalidConfigFileException extends BacktoryException
{
    /**
     * @var string
     */
    protected $message = Messages::EXCEPTION_INVALID_CONFIG_FILE;
}