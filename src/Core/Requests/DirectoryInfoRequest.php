<?php
namespace Backtory\Storage\Core\Requests;

use Backtory\Storage\Core\Contract\BacktoryApiUrl;

/**
 * Class DirectoryInfoRequest
 * @package Backtory\Storage\Core\Requests
 */
class DirectoryInfoRequest extends StorageRequest
{

    /**
     * @return array
     */
    function generateRequestData()
    {
        return [$this->getPayLoad() => $this->getData()];
    }

    /**
     * @return mixed
     */
    protected function getUri()
    {
        return BacktoryApiUrl::DIRECTORY_INFO_URI;
    }
}