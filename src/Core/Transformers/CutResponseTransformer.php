<?php
namespace Backtory\Storage\Core\Transformers;

use Backtory\Storage\Core\Interfaces\ResponseTransformer;
use Backtory\Storage\Core\Responses\StorageResponse;

/**
 * Class CutResponseTransformer
 * @package Backtory\Storage\Core\Transformers
 */
class CutResponseTransformer implements ResponseTransformer
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