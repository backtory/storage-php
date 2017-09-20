<?php
namespace Backtory\Storage\Core\Interfaces;

use Backtory\Storage\Core\Responses\StorageResponse;

/**
 * Interface ResponseTransformer
 * @package Backtory\Storage\Core\Interfaces
 */
interface ResponseTransformer
{
    /**
     * @param StorageResponse $response
     * @return mixed
     */
    function transform(StorageResponse $response);
}