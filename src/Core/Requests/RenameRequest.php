<?php
namespace Backtory\Storage\Core\Requests;

use Backtory\Storage\Core\Contract\BacktoryApiUrl;
use Backtory\Storage\Core\Helpers\StorageRequestUtility;

/**
 * Class RenameRequest
 * @package Backtory\Storage\Core\Requests
 */
class RenameRequest extends StorageRequest
{

    /**
     * @return array
     */
    function generateRequestData()
    {
        $requestUtility = new StorageRequestUtility();

        $result = [];
        foreach ($this->getData() as $data) {
            if (!is_array($data) || !isset($data[0], $data[1])) {
                continue;
            }

            $result['items'][] = [
                "pathToRename" => $requestUtility->pathStartCorrector($data[0]),
                "newFileName" => $data[1]
            ];
        }

        return [$this->getPayLoad() => $result];
    }

    /**
     * @return mixed
     */
    protected function getUri()
    {
        return BacktoryApiUrl::RENAME_URI;
    }
}