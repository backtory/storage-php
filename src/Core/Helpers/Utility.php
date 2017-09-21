<?php
namespace Backtory\Storage\Core\Helpers;

use Exception;

/**
 * Class Utility
 * @package Backtory\Storage\Core\Helpers
 */
class Utility
{
    /**
     * @param $address
     * @param $destination
     * @param null $name
     * @return bool
     */
    public static function download($address, $destination, $name = null)
    {
        try {
            if (empty($destination)) {
                return false;
            }
            if (empty($name)) {
                $name = self::getFileName($address);
            }

            $fp = fopen($destination . DIRECTORY_SEPARATOR . $name, 'w+');
            fwrite($fp, file_get_contents($address));
            fclose($fp);

            return true;
        } catch (Exception $exception) {
            return false;
        }
    }

    /**
     * @param $path
     * @return string
     */
    public static function getFileName($path)
    {
        $revPath = strrev($path);
        return urldecode(strrev(substr($revPath, 0, stripos($revPath, "/"))));
    }
}