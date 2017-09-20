<?php
namespace Backtory\Storage\Core\Interfaces;

use Backtory\Storage\Core\Requests\StorageRequest;

/**
 * Interface HttpClientAdapter
 * @package Backtory\Storage\Core\Interfaces
 */
interface HttpClientAdapter
{
    /**
     * @param StorageRequest $storageRequest
     * @return mixed
     */
    function directoryInfo(StorageRequest $storageRequest);

    /**
     * @param StorageRequest $storageRequest
     * @return mixed
     */
    function fileInfo(StorageRequest $storageRequest);

    /**
     * @param StorageRequest $storageRequest
     * @return mixed
     */
    function delete(StorageRequest $storageRequest);

    /**
     * @param StorageRequest $storageRequest
     * @return mixed
     */
    function copy(StorageRequest $storageRequest);

    /**
     * @param StorageRequest $storageRequest
     * @return mixed
     */
    function upload(StorageRequest $storageRequest);

    /**
     * @param StorageRequest $storageRequest
     * @return mixed
     */
    function createDirectory(StorageRequest $storageRequest);

    /**
     * @param StorageRequest $storageRequest
     * @return mixed
     */
    function cut(StorageRequest $storageRequest);

    /**
     * @param StorageRequest $storageRequest
     * @return mixed
     */
    function rename(StorageRequest $storageRequest);

    /**
     * @param StorageRequest $storageRequest
     * @return mixed
     */
    function auth(StorageRequest $storageRequest);
}