<?php
namespace Backtory\Storage\Core\Requests;

use Backtory\Storage\Core\Contract\BacktoryApiUrl;
use Backtory\Storage\Core\Helpers\StorageRequestUtility;

class CopyRequest extends StorageRequest
{
    /**
     * @param array $data
     * @return array
     */
    public static function copyCutRequestGenerator(array $data)
    {
        $requestUtility = new StorageRequestUtility();

        $files = $data[0];
        $destination = $data[1];
        $force = $data[2];

        foreach ($files as $index => $file) {
            $files[$index] = $requestUtility->pathStartCorrector($file);
        }

        return [
            "sourceUrls" => $files,
            "destinationUrl" => $requestUtility->pathCorrector($destination),
            "forces" => array_fill(0, count($files), $force ? "true" : "false")
        ];
    }

    /**
     * @return array
     */
    function generateRequestData()
    {
        return [$this->getPayLoad() => self::copyCutRequestGenerator($this->getData())];
    }

    /**
     * @return mixed
     */
    protected function getUri()
    {
        return BacktoryApiUrl::COPY_URI;
    }
}