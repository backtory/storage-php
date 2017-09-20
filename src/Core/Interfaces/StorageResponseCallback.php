<?php
namespace Backtory\Storage\Core\Interfaces;

use Backtory\Storage\Core\Responses\StorageResponse;

/**
 * Interface StorageResponseCallback
 * @package Backtory\Storage\Core\Interfaces
 */
interface StorageResponseCallback
{
    /**
     * @param StorageResponse $response
     * @return mixed
     */
    function handle(StorageResponse $response);

    /**
     * @param StorageResponse $response
     * @return mixed
     */
    function failed(StorageResponse $response);
}