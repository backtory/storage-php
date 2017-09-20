<?php
namespace Backtory\Storage\Core\Requests;

use Backtory\Storage\Core\Contract\BacktoryApiUrl;

/**
 * Class CreateDirectoryRequest
 * @package Backtory\Storage\Core\Requests
 */
class CreateDirectoryRequest extends StorageRequest
{

    /**
     * @return array
     */
    function generateRequestData()
    {
        return [$this->getPayLoad() => ["path" => $this->getData()]];
    }

    /**
     * @return mixed
     */
    protected function getUri()
    {
        return BacktoryApiUrl::CREATE_DIRECTORY;
    }
}