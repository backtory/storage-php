<?php
namespace Backtory\Storage\Core\Helpers;

use Backtory\Storage\Core\Contract\Keys;

/**
 * Class FileDirectoryUtility
 * @package Backtory\Storage\Core\Helper
 */
class StorageRequestUtility
{
    /**
     * @param $path
     * @return string
     */
    public function pathCorrector($path)
    {
        $path = $this->pathStartCorrector($path);

        if (substr($path, strlen($path) - 1) != "/") {
            $path = "{$path}/";
        }

        return $path;
    }

    /**
     * @param array $headers
     * @return array
     */
    public function headersCorrector(array $headers)
    {
        foreach ($headers as $key => $value) {
            if (!strpos($key, Keys::HEADERS_START_KEY)) {
                $headers[Keys::HEADERS_START_KEY . $key] = $headers[$key];
                unset($headers[$key]);
            }
        }

        return $headers;
    }

    /**
     * @param $path
     * @return string
     */
    public function pathStartCorrector($path)
    {
        if (empty($path)) {
            return "/";
        }
        if (substr($path, 0, 1) != "/") {
            $path = "/{$path}";
        }

        return $path;
    }

}