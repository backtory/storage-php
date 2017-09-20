<?php
namespace Backtory\Storage\Core\Requests;

use Backtory\Storage\Core\Contract\BacktoryApiUrl;

/**
 * Class CutRequest
 * @package Backtory\Storage\Core\Requests
 */
class CutRequest extends StorageRequest
{

    /**
     * @return array
     */
    function generateRequestData()
    {
        return [$this->getPayLoad() => CopyRequest::copyCutRequestGenerator($this->getData())];
    }

    /**
     * @return mixed
     */
    protected function getUri()
    {
        return BacktoryApiUrl::CUT_URI;
    }
}