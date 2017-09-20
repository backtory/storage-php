<?php
namespace Backtory\Storage\Core\Facade;

use Backtory\Storage\Adapters\HttpClient\Guzzle\GuzzleLogObserver;
use Backtory\Storage\Core\Contract\ApplicationConfig;
use Backtory\Storage\Core\Contract\Keys;
use Backtory\Storage\Core\Exception\BacktoryApiCallException;
use Backtory\Storage\Core\Exception\BacktoryConfigFileNotFoundException;
use Backtory\Storage\Core\Exception\BacktoryConfigurationNotSetException;
use Backtory\Storage\Core\Exception\BacktoryException;
use Backtory\Storage\Core\Exception\BacktoryInvalidConfigFileException;
use Backtory\Storage\Core\Exception\BacktoryInvalidFileParameterException;
use Backtory\Storage\Core\Exception\BacktoryMissingFileConfigParameter;
use Backtory\Storage\Core\Exception\BacktoryUnsupportedConfigFileFormatException;
use Backtory\Storage\Core\Helpers\Utility;
use Backtory\Storage\Core\Service\StorageService;
use Backtory\Storage\Core\Service\StorageServiceBuilder;
use Exception;
use Noodlehaus\Config;
use Noodlehaus\Exception\FileNotFoundException;
use Noodlehaus\Exception\UnsupportedFormatException;

/**
 * Class BacktoryStorage
 * @package Backtory\Storage\Core\Facade
 */
class BacktoryStorage
{
    /**
     * @var
     */
    private static $instance;

    /**
     * @param $xBacktoryAuthenticationId
     * @param $xBacktoryAuthenticationKey
     * @param $xBacktoryObjectStorageId
     * @return static
     */
    public static function init(
        $xBacktoryAuthenticationId,
        $xBacktoryAuthenticationKey,
        $xBacktoryObjectStorageId)
    {
        if (!empty(self::$instance)) {
            return self::$instance;
        }

        self::buildStorageService($xBacktoryAuthenticationId, $xBacktoryAuthenticationKey, $xBacktoryObjectStorageId);

        return self::$instance = new static();
    }

    /**
     * @param $configFilePath
     * @return static
     * @throws BacktoryConfigFileNotFoundException
     * @throws BacktoryInvalidConfigFileException
     * @throws BacktoryMissingFileConfigParameter
     * @throws BacktoryUnsupportedConfigFileFormatException
     */
    public static function initWithConfigFile($configFilePath)
    {
        if (!empty(self::$instance)) {
            return self::$instance;
        }

        try {
            $config = Config::load($configFilePath);
        } catch (FileNotFoundException $exception) {
            throw new BacktoryConfigFileNotFoundException();
        } catch (UnsupportedFormatException $exception) {
            throw new BacktoryUnsupportedConfigFileFormatException();
        } catch (Exception $exception) {
            throw new BacktoryInvalidConfigFileException();
        }

        $isConfigFileValid = true;
        $isConfigFileValid &= $config->has(Keys::X_BACKTORY_AUTHENTICATION_ID);
        $isConfigFileValid &= $config->has(Keys::X_BACKTORY_AUTHENTICATION_KEY);
        $isConfigFileValid &= $config->has(Keys::X_BACKTORY_OBJECT_STORAGE_ID);

        if ($isConfigFileValid) {
            GuzzleLogObserver::$LOG_PATH = $config->get(Keys::LOG_PATH, "");

            $storageService = self::buildStorageService(
                $config->get(Keys::X_BACKTORY_AUTHENTICATION_ID),
                $config->get(Keys::X_BACKTORY_AUTHENTICATION_KEY),
                $config->get(Keys::X_BACKTORY_OBJECT_STORAGE_ID)
            );

            $storageService->setHeaders($config->get(Keys::HEADERS, []));
            $storageService->setParameters($config->get(Keys::PARAMETERS, []));
            $storageService->setDomain($config->get(Keys::DOMAIN, $storageService->getDomain()));

            return self::$instance = new static();
        }

        throw new BacktoryMissingFileConfigParameter();
    }

    /**
     * @param $authId
     * @param $authKey
     * @param $instanceId
     * @return StorageService
     */
    private static function buildStorageService($authId, $authKey, $instanceId)
    {
        return StorageServiceBuilder::builder()
            ->setAuthenticationId($authId)
            ->setAuthenticationKey($authKey)
            ->setInstanceId($instanceId)
            ->build();
    }

    /**
     * @throws BacktoryConfigurationNotSetException
     */
    private static function throwIfNotInit()
    {
        if (empty(self::$instance)) {
            throw new BacktoryConfigurationNotSetException();
        }
    }

    /**
     * @param $domain
     */
    public static function setDomain($domain)
    {
        StorageService::setDomain($domain);
    }

    /**
     * @param array $headers
     */
    public static function setHeader(array $headers)
    {
        self::throwIfNotInit();

        StorageService::getInstance()
            ->setHeaders($headers);
    }

    /**
     * @param $key
     * @param $value
     */
    public static function addHeader($key, $value)
    {
        self::throwIfNotInit();

        StorageService::getInstance()
            ->addHeader($key, $value);
    }

    /**
     * @param array $parameters
     */
    public static function setParameters(array $parameters)
    {
        self::throwIfNotInit();

        StorageService::getInstance()
            ->setParameters($parameters);
    }

    /**
     * @param $key
     * @param $value
     */
    public static function addParameter($key, $value)
    {
        self::throwIfNotInit();

        StorageService::getInstance()
            ->addParameter($key, $value);
    }

    /**
     * @return StorageService
     */
    public function getStorageService()
    {
        return StorageService::getInstance();
    }

    /**
     * @param $path
     * @return mixed
     */
    public static function createDirectory($path)
    {
        self::throwIfNotInit();

        return StorageService::getInstance()
            ->createDirectory($path);
    }

    /**
     * @param string $path
     * @param int $pageNumber
     * @param int $pageSize
     * @param string $sort
     * @return mixed
     */
    public static function directoryInfo(
        $path = "/",
        $pageNumber = 0,
        $pageSize = ApplicationConfig::DIRECTORY_INFO_MAX_PAGE_COUNT,
        $sort = "ASC"
    )
    {
        self::throwIfNotInit();

        return StorageService::getInstance()
            ->directoryInfo($path, $pageNumber, $pageSize, $sort);
    }

    /**
     * @param $fileOrPath
     * @param string $backtoryStoragePath
     * @param bool $replace
     * @return mixed
     * @throws BacktoryInvalidFileParameterException
     */
    public static function put($fileOrPath, $backtoryStoragePath = "/", $replace = true)
    {
        self::throwIfNotInit();

        $file = null;
        if (is_resource($fileOrPath)) {
            $file = $fileOrPath;
        } elseif (is_file($fileOrPath)) {
            $file = fopen($fileOrPath, 'r');
        } else {
            throw new BacktoryInvalidFileParameterException();
        }

        return StorageService::getInstance()
            ->addFile($file, $backtoryStoragePath, $replace)
            ->upload();
    }

    /**
     * @param $files
     * @return mixed
     */
    public static function putFiles($files)
    {
        self::throwIfNotInit();

        $storageService = StorageService::getInstance();

        foreach ($files as $file) {
            if (array_key_exists(Keys::FILE, $file)) {
                $storageService->addFile(
                    $file[Keys::FILE],
                    isset($file[Keys::BACKTORY_STORAGE_PATH]) ? $file[Keys::BACKTORY_STORAGE_PATH] : "/",
                    isset($file[Keys::REPLACE]) ? $file[Keys::REPLACE] : true
                );
            }
        }

        return $storageService->upload();
    }

    /**
     * @param $filePath
     * @return mixed|null
     * @throws BacktoryException
     */
    public static function fileInfo($filePath)
    {
        self::throwIfNotInit();

        try {
            return StorageService::getInstance()
                ->fileInfo($filePath);
        } catch (BacktoryException $exception) {
            if ($exception->getCode() == 404) {
                return null;
            }

            throw $exception;
        }
    }

    /**
     * @param $filePath
     * @return bool
     */
    public static function exists($filePath)
    {
        return empty(self::fileInfo($filePath)) ? false : true;
    }

    /**
     * @param $path
     * @param bool $force
     * @return bool
     */
    public static function delete($path, $force = true)
    {
        self::throwIfNotInit();

        if (!is_array($path)) {
            $path = [$path];
        }

        try {
            StorageService::getInstance()
                ->delete($path, $force);

            return true;
        } catch (BacktoryApiCallException $exception) {
            return false;
        }
    }

    /**
     * @param $files
     * @param $destination
     * @param bool $force
     * @return mixed
     */
    public static function copy($files, $destination, $force = true)
    {
        self::throwIfNotInit();

        if (!is_array($files)) {
            $files = [$files];
        }

        return StorageService::getInstance()
            ->copy($files, $destination, $force);
    }

    /**
     * @param $files
     * @param $destination
     * @param bool $force
     * @return mixed
     */
    public static function move($files, $destination, $force = true)
    {
        self::throwIfNotInit();

        if (!is_array($files)) {
            $files = [$files];
        }

        return StorageService::getInstance()
            ->cut($files, $destination, $force);
    }

    /**
     * @param $path
     * @param $newName
     * @return null
     */
    public static function rename($path, $newName)
    {
        return self::renameFiles([[$path, $newName]]);
    }

    /**
     * @param array $files
     * @return null
     */
    public static function renameFiles(array $files)
    {
        self::throwIfNotInit();

        if (empty($files)) {
            return null;
        }

        return StorageService::getInstance()
            ->rename((is_array($files[0]) ? $files : [$files]));
    }

    /**
     * @param $filePath
     * @param null $destinationDir
     * @param null $name
     * @return bool|null|string
     */
    public static function get($filePath, $destinationDir = null, $name = null)
    {
        if (empty($filePath)) {
            return null;
        }

        $filePath = self::url($filePath);

        if (!isset($destinationDir)) {
            return file_get_contents($filePath);
        }

        return Utility::download($filePath, $destinationDir, $name);
    }

    /**
     * @param $filePath
     * @return bool|string
     */
    public static function url($filePath)
    {
        self::throwIfNotInit();

        $info = self::fileInfo($filePath);

        if (empty($info)) {
            return false;
        }

        $host = empty((StorageService::getDomain())) ? ApplicationConfig::STORAGE_BASE_URL : StorageService::getDomain();

        return "{$host}/{$info['url']}";
    }
}