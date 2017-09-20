<?php
namespace Backtory\Storage\Core\Exception;

use Backtory\Storage\Core\Contract\Messages;

/**
 * Class BacktoryUnsupportedConfigFileFormatException
 * @package Backtory\Storage\Core\Exception
 */
class BacktoryUnsupportedConfigFileFormatException extends BacktoryException
{
    /**
     * @var string
     */
    protected $message = Messages::EXCEPTION_UNSUPPORTED_CONFIG_FILE_FORMAT;
}