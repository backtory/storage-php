<?php
namespace Backtory\Storage\Core\Exception;

use Backtory\Storage\Core\Contract\Messages;

/**
 * Class BacktoryConfigFileNotFoundException
 * @package Backtory\Storage\Core\Exception
 */
class BacktoryConfigFileNotFoundException extends BacktoryException
{
    /**
     * @var string
     */
    protected $message = Messages::EXCEPTION_CONFIG_FILE_NOT_FOUND;
}