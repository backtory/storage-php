<?php
namespace Backtory\Storage\Core\Requests;

use Backtory\Storage\Core\Contract\BacktoryApiUrl;

/**
 * Class FileInfoRequest
 * @package Backtory\Storage\Core\Requests
 */
class FileInfoRequest extends StorageRequest
{

    /**
     * @return array
     */
    function generateRequestData()
    {
        return [$this->getPayLoad() => ["url" => $this->getData()]];
    }

    /**
     * @return mixed
     */
    protected function getUri()
    {
        return BacktoryApiUrl::FILE_INFO_URI;
    }
}