<?php
namespace Backtory\Storage\Core\Transformers;

use Backtory\Storage\Core\Interfaces\ResponseTransformer;
use Backtory\Storage\Core\Responses\StorageResponse;

/**
 * Class DirectoryInfoResponseTransformer
 * @package Backtory\Storage\Core\Transformers
 */
class DirectoryInfoResponseTransformer implements ResponseTransformer
{
    /**
     * @param StorageResponse $response
     * @return mixed
     */
    function transform(StorageResponse $response)
    {
        return $response->getBody()->files;
    }
}