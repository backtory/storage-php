<?php
namespace Backtory\Storage\Core\Requests;

use Backtory\Storage\Core\Contract\BacktoryApiUrl;
use Backtory\Storage\Core\Helpers\StorageRequestUtility;

/**
 * Class DeleteRequest
 * @package Backtory\Storage\Core\Requests
 */
class DeleteRequest extends StorageRequest
{

    /**
     * @return array
     */
    function generateRequestData()
    {
        $requestUtility = new StorageRequestUtility();

        $files = $this->getData()[0];
        $force = array_fill(0, count($files), $this->getData()[1]);
        foreach ($files as $index => $path) {
            $files[$index] = $requestUtility->pathStartCorrector($path);
        }

        return [$this->getPayLoad() => [
            "urls" => $files, "forced" => $force
        ]];
    }

    /**
     * @return mixed
     */
    protected function getUri()
    {
        return BacktoryApiUrl::DELETE_URI;
    }
}