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
                $revAddress = strrev($address);
                $name = urldecode(strrev(substr($revAddress, 0, stripos($revAddress, "/"))));
            }

            $fp = fopen($destination . DIRECTORY_SEPARATOR . $name, 'w+');
            fwrite($fp, file_get_contents($address));
            fclose($fp);

            return true;
        } catch (Exception $exception) {
            return false;
        }
    }
}