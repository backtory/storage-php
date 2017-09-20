<?php
namespace Backtory\Storage\Core\Exception;

use Backtory\Storage\Core\Contract\Messages;

/**
 * Class BacktoryInvalidFileParameterException
 * @package Backtory\Storage\Core\Exception
 */
class BacktoryInvalidFileParameterException extends BacktoryException
{
    /**
     * @var string
     */
    protected $message = Messages::EXCEPTION_INVALID_FILE_PARAMETER;
}