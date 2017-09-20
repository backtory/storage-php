<?php
namespace Backtory\Storage\Core\Exception;

use Backtory\Storage\Core\Contract\Messages;

/**
 * Class BacktoryMissingFileConfigParameter
 * @package Backtory\Storage\Core\Exception
 */
class BacktoryMissingFileConfigParameter extends BacktoryException
{
    /**
     * @var string
     */
    protected $message = Messages::EXCEPTION_MISSING_FILE_CONFIG_PARAMETER;
}