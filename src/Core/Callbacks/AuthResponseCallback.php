<?php
namespace Backtory\Storage\Core\Callbacks;

use Backtory\Storage\Core\Contract\Messages;
use Backtory\Storage\Core\Exception\BacktoryGetTokenException;
use Backtory\Storage\Core\Interfaces\StorageResponseCallback;
use Backtory\Storage\Core\Responses\StorageResponse;
use Backtory\Storage\Core\Service\StorageService;

/**
 * Class AuthResponseCallback
 * @package Backtory\Storage\Core\Callbacks
 */
class AuthResponseCallback implements StorageResponseCallback
{
    /**
     * @param StorageResponse $response
     */
    function handle(StorageResponse $response)
    {
        $storageService = StorageService::getInstance();
        $storageService->setToken($response->getBody()->access_token);
    }

    /**
     * @param StorageResponse $response
     * @throws BacktoryGetTokenException
     */
    function failed(StorageResponse $response)
    {
        throw new BacktoryGetTokenException(Messages::EXCEPTION_GET_TOKEN_FAILED);
    }
}