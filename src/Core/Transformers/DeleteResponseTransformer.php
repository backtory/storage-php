<?php
namespace Backtory\Storage\Core\Transformers;

use Backtory\Storage\Core\Interfaces\ResponseTransformer;
use Backtory\Storage\Core\Responses\StorageResponse;

/**
 * Class DeleteResponseTransformer
 * @package Backtory\Storage\Core\Transformers
 */
class DeleteResponseTransformer implements ResponseTransformer
{

    /**
     * @param StorageResponse $response
     * @return bool
     */
    function transform(StorageResponse $response)
    {
        return true;
    }
}