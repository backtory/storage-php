<?php
namespace Backtory\Storage\Core\Transformers;

use Backtory\Storage\Core\Interfaces\ResponseTransformer;
use Backtory\Storage\Core\Responses\StorageResponse;

/**
 * Class FileInfoResponseTransformer
 * @package Backtory\Storage\Core\Transformers
 */
class FileInfoResponseTransformer implements ResponseTransformer
{

    /**
     * @param StorageResponse $response
     * @return array
     */
    function transform(StorageResponse $response)
    {
        return (array)$response->getBody();
    }
}