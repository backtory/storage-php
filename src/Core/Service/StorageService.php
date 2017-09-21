<?php
namespace Backtory\Storage\Core\Service;

use Backtory\Storage\Core\Callbacks\AuthResponseCallback;
use Backtory\Storage\Core\Contract\ApplicationConfig;
use Backtory\Storage\Core\Contract\Keys;
use Backtory\Storage\Core\Contract\Messages;
use Backtory\Storage\Core\Exception\BacktoryInvalidParameterException;
use Backtory\Storage\Core\Helpers\StorageRequestUtility;
use Backtory\Storage\Core\Interfaces\HttpClientAdapter;
use Backtory\Storage\Core\Interfaces\ResponseTransformer;
use Backtory\Storage\Core\Requests\AuthRequest;
use Backtory\Storage\Core\Requests\CopyRequest;
use Backtory\Storage\Core\Requests\CreateDirectoryRequest;
use Backtory\Storage\Core\Requests\CutRequest;
use Backtory\Storage\Core\Requests\DeleteRequest;
use Backtory\Storage\Core\Requests\DirectoryInfoRequest;
use Backtory\Storage\Core\Requests\FileInfoRequest;
use Backtory\Storage\Core\Requests\RenameRequest;
use Backtory\Storage\Core\Requests\StorageRequest;
use Backtory\Storage\Core\Requests\UploadStorageRequest;
use Backtory\Storage\Core\Transformers\CopyResponseTransformer;
use Backtory\Storage\Core\Transformers\CreateDirectoryResponseTransformer;
use Backtory\Storage\Core\Transformers\CutResponseTransformer;
use Backtory\Storage\Core\Transformers\DeleteResponseTransformer;
use Backtory\Storage\Core\Transformers\DirectoryInfoResponseTransformer;
use Backtory\Storage\Core\Transformers\FileInfoResponseTransformer;
use Backtory\Storage\Core\Transformers\RenameResponseTransformer;
use Backtory\Storage\Core\Transformers\UploadResponseTransformer;

/**
 * Class StorageService
 * @package Backtory\Storage\Core\Service
 */
class StorageService
{
    /**
     * @var
     */
    private static $instance;
    /**
     * @var
     */
    private static $domain;
    /**
     * @var
     */
    private $token;
    /**
     * @var
     */
    private $instanceId;
    /**
     * @var
     */
    private $httpClient;
    /**
     * @var array
     */
    private $files = [];

    /**
     * @var StorageRequestUtility
     */
    private $requestUtility;
    /**
     * @var array
     */
    private $parameters = [];
    /**
     * @var array
     */
    private $headers = [];

    /**
     * StorageService constructor.
     * @param HttpClientAdapter $httpClient
     */
    private function __construct(HttpClientAdapter $httpClient)
    {
        $this->requestUtility = new StorageRequestUtility();
        $this->httpClient = $httpClient;
    }

    /**
     * @param HttpClientAdapter $httpClient
     * @return StorageService
     * @throws BacktoryInvalidParameterException
     */
    public static function getInstance(HttpClientAdapter $httpClient = null)
    {
        if (self::$instance == null && $httpClient == null) {
            throw new BacktoryInvalidParameterException(Messages::EXCEPTION_INVALID_PARAMETER);
        }
        if (self::$instance == null) {
            self::$instance = new StorageService($httpClient);
        }

        return self::$instance;
    }

    /**
     * @param $domain
     */
    public static function setDomain($domain)
    {
        self::$domain = $domain;
    }

    /**
     * @return mixed
     */
    public static function getDomain()
    {
        return self::$domain;
    }

    /**
     * @return array
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * @param array $parameters
     * @return $this
     */
    public function setParameters($parameters)
    {
        $this->parameters = $parameters;

        return $this;
    }

    /**
     * @param $key
     * @param $value
     */
    public function addParameter($key, $value)
    {
        $this->parameters[] = [
            $key => $value
        ];
    }

    /**
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @param array $headers
     * @return $this
     */
    public function setHeaders(array $headers)
    {
        $this->headers = $headers;

        return $this;
    }

    /**
     * @param $key
     * @param $value
     * @return $this
     */
    public function addHeader($key, $value)
    {
        $this->headers[] = [$key => $value];

        return $this;
    }


    /**
     * @param $token
     * @return $this
     */
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @return mixed
     */
    public function getInstanceId()
    {
        return $this->instanceId;
    }

    /**
     * @param mixed $instanceId
     * @return $this
     */
    public function setInstanceId($instanceId)
    {
        $this->instanceId = $instanceId;

        return $this;
    }

    /**
     * @param $file
     * @param string $path
     * @param bool $replace
     * @return $this
     * @throws BacktoryInvalidParameterException
     */
    public function addFile($file, $path = "/", $replace = true)
    {
        if (!is_resource($file)) {
            throw new BacktoryInvalidParameterException(Messages::EXCEPTION_INVALID_PARAMETER);
        }

        $this->files[] = [
            Keys::BACKTORY_STORAGE_PATH => $this->requestUtility->pathCorrector($path),
            Keys::FILE => $file,
            Keys::REPLACE => $replace
        ];

        return $this;
    }


    /**
     *
     */
    public function emptyFileList()
    {
        foreach ($this->files as $file) {
            if (is_resource($file)) {
                fclose($file);
            }
        }

        $this->files = [];

        return $this;
    }

    /**
     * @param StorageRequest $request
     * @param $data
     * @param ResponseTransformer $transformer
     * @return StorageRequest
     */
    private function generateStorageRequest(StorageRequest $request, $data, ResponseTransformer $transformer = null)
    {
        $headers = $this->requestUtility->headersCorrector($this->headers);
        if (!empty($this->token)) {
            $headers["Authorization"] = "Bearer {$this->token}";
            $headers["X-Backtory-Storage-Id"] = $this->instanceId;
        }

        $request->setData($data)
            ->setParams($this->parameters)
            ->setHeaders($headers)
            ->setTransformer($transformer);

        return $request;
    }

    /**
     * @param $authId
     * @param $authKey
     */
    public function auth($authId, $authKey)
    {
        $storageRequest = new AuthRequest();
        $storageRequest->setHeaders([
            "X-Backtory-Authentication-Id" => $authId,
            "X-Backtory-Authentication-Key" => $authKey
        ]);
        $storageRequest->setCallback(new AuthResponseCallback());

        $this->httpClient->auth($storageRequest);
    }

    /**
     * @return mixed
     */
    public function upload()
    {
        if (empty($this->files)) {
            return [];
        }

        $result = $this->httpClient->upload($this->generateStorageRequest(
            new UploadStorageRequest(), $this->files, new UploadResponseTransformer())
        );

        $this->emptyFileList();

        return $result;
    }

    /**
     * @param $filePath
     * @return mixed
     * @throws BacktoryInvalidParameterException
     */
    public function fileInfo($filePath)
    {
        if (empty($filePath)) {
            throw new BacktoryInvalidParameterException();
        }

        return $this->httpClient->fileInfo(
            $this->generateStorageRequest(
                new FileInfoRequest(),
                $this->requestUtility->pathStartCorrector($filePath),
                new FileInfoResponseTransformer()
            )
        );
    }

    /**
     * @param string $path
     * @param int $pageNumber
     * @param int $pageSize
     * @param string $sort
     * @return mixed
     */
    public function directoryInfo($path = "/", $pageNumber = 0, $pageSize = 50, $sort = "ASC")
    {
        if ($pageSize > ApplicationConfig::DIRECTORY_INFO_MAX_PAGE_COUNT) {
            $pageSize = ApplicationConfig::DIRECTORY_INFO_MAX_PAGE_COUNT;
        }

        $path = $this->requestUtility->pathCorrector($path);

        return $this->httpClient->directoryInfo(
            $this->generateStorageRequest(new DirectoryInfoRequest(), [
                Keys::URL => $path,
                Keys::PAGE => $pageNumber,
                Keys::PAGE_COUNT => $pageSize,
                Keys::SORT => $sort
            ], new DirectoryInfoResponseTransformer())
        );
    }

    /**
     * @param array $path
     * @param bool $force
     * @return mixed
     */
    public function delete(array $path, $force = true)
    {
        return $this->httpClient->delete(
            $this->generateStorageRequest(
                new DeleteRequest(),
                [$path, $force],
                new DeleteResponseTransformer()
            )
        );
    }

    /**
     * @param array $files
     * @param $destination
     * @param bool $force
     * @return mixed
     */
    public function copy(array $files, $destination, $force = true)
    {
        return $this->httpClient->copy(
            $this->generateStorageRequest(
                new CopyRequest(),
                [$files, $destination, $force],
                new CopyResponseTransformer()
            )
        );
    }

    /**
     * @param array $files
     * @param $destination
     * @param bool $force
     * @return mixed
     */
    public function cut(array $files, $destination, $force = true)
    {
        return $this->httpClient->cut(
            $this->generateStorageRequest(
                new CutRequest(),
                [$files, $destination, [$force]],
                new CutResponseTransformer()
            )
        );
    }

    /**
     * @param $path
     * @return mixed
     */
    public function createDirectory($path)
    {
        return $this->httpClient->createDirectory(
            $this->generateStorageRequest(new CreateDirectoryRequest(), $path, new CreateDirectoryResponseTransformer())
        );
    }

    /**
     * @param $files
     * @return mixed
     * @throws BacktoryInvalidParameterException
     */
    public function rename($files)
    {
        if (!isset($files[0]) || !is_array($files[0]) || count($files[0]) < 2) {
            throw new BacktoryInvalidParameterException();
        }

        return $this->httpClient->rename($this->generateStorageRequest(
            new RenameRequest(),
            $files,
            new RenameResponseTransformer()
        ));
    }
}