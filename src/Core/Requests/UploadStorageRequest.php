<?php
namespace Backtory\Storage\Core\Requests;

use Backtory\Storage\Core\Contract\BacktoryApiUrl;
use Backtory\Storage\Core\Contract\Keys;

/**
 * Class UploadStorageRequest
 * @package Backtory\Storage\Core\Requests
 */
class UploadStorageRequest extends StorageRequest
{
    /**
     * @return mixed
     */
    function getUri()
    {
        return BacktoryApiUrl::UPLOAD_URI;
    }

    /**
     * @return array
     */
    function generateRequestData()
    {
        $result = [];
        foreach ($this->data as $i => $data) {
            $result[] = [
                'name' => "fileItems[{$i}].path",
                'contents' => $data[Keys::BACKTORY_STORAGE_PATH]
            ];
            $result[] = [
                'name' => "fileItems[{$i}].fileToUpload",
                'contents' => $data[Keys::FILE]
            ];
            $result[] = [
                'name' => "fileItems[{$i}].replacing",
                'contents' => $data[Keys::REPLACE]
            ];
        }

        return empty($this->getPayLoad()) ? $result : [$this->getPayLoad() => $result];
    }
}