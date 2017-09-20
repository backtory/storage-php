<?php
namespace Backtory\Storage\Core\Requests;

use Backtory\Storage\Core\Contract\BacktoryApiUrl;

/**
 * Class AuthRequest
 * @package Backtory\Storage\Core\Requests
 */
class AuthRequest extends StorageRequest
{

    /**
     * @return mixed
     */
    protected function getUri()
    {
        return BacktoryApiUrl::LOGIN_URL;
    }

    /**
     * @return array
     */
    function generateRequestData()
    {
        return [];
    }
}