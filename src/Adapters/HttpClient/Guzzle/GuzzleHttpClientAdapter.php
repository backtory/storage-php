<?php
namespace Backtory\Storage\Adapters\HttpClient\Guzzle;

use Backtory\Storage\Core\Interfaces\HttpClientAdapter;
use Backtory\Storage\Core\Requests\StorageRequest;

/**
 * Class GuzzleHttpClientAdapter
 * @package Backtory\Storage\Adapters\HttpClient\Guzzle
 */
class GuzzleHttpClientAdapter implements HttpClientAdapter
{
    /**
     * @var GuzzleService
     */
    private $guzzleService;

    /**
     * GuzzleHttpClientAdapter constructor.
     */
    function __construct()
    {
        $this->guzzleService = new GuzzleService();
    }

    /**
     * @param StorageRequest $storageRequest
     */
    function auth(StorageRequest $storageRequest)
    {
        $this->guzzleService->formRequest($storageRequest);
    }

    /**
     * @param StorageRequest $storageRequest
     * @return \Psr\Http\Message\StreamInterface
     */
    function createDirectory(StorageRequest $storageRequest)
    {
        return $this->guzzleService->jsonRawRequest($storageRequest);
    }

    /**
     * @param StorageRequest $storageRequest
     * @return \Psr\Http\Message\StreamInterface
     */
    function directoryInfo(StorageRequest $storageRequest)
    {
        return $this->guzzleService->jsonRawRequest($storageRequest);
    }

    /**
     * @param StorageRequest $storageRequest
     * @return \Psr\Http\Message\StreamInterface
     */
    function upload(StorageRequest $storageRequest)
    {
        return $this->guzzleService->multipartRequest($storageRequest);
    }

    /**
     * @param StorageRequest $storageRequest
     * @return \Psr\Http\Message\StreamInterface
     */
    function fileInfo(StorageRequest $storageRequest)
    {
        return $this->guzzleService->jsonRawRequest($storageRequest);
    }

    /**
     * @param StorageRequest $storageRequest
     * @return \Psr\Http\Message\StreamInterface
     */
    function copy(StorageRequest $storageRequest)
    {
        return $this->guzzleService->jsonRawRequest($storageRequest);
    }

    /**
     * @param StorageRequest $storageRequest
     * @return \Psr\Http\Message\StreamInterface
     */
    function cut(StorageRequest $storageRequest)
    {
        return $this->guzzleService->jsonRawRequest($storageRequest);
    }

    /**
     * @param StorageRequest $storageRequest
     * @return \Psr\Http\Message\StreamInterface
     */
    function delete(StorageRequest $storageRequest)
    {
        return $this->guzzleService->jsonRawRequest($storageRequest, GuzzleService::DELETE);
    }

    /**
     * @param StorageRequest $storageRequest
     * @return \Psr\Http\Message\StreamInterface
     */
    function rename(StorageRequest $storageRequest)
    {
        return $this->guzzleService->jsonRawRequest($storageRequest);
    }
}