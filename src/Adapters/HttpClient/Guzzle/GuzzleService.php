<?php
namespace Backtory\Storage\Adapters\HttpClient\Guzzle;

use Backtory\Storage\Core\Exception\BacktoryApiCallException;
use Backtory\Storage\Core\Requests\StorageRequest;
use Backtory\Storage\Core\Responses\StorageResponse;
use Exception;
use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

/**
 * Class GuzzleService
 * @package Backtory\Storage\Adapters\HttpClient\Guzzle
 */
class GuzzleService
{
    /**
     * @var Client
     */
    private $client;
    /**
     *
     */
    const GET = "GET";
    /**
     *
     */
    const POST = "POST";
    /**
     *
     */
    const PUT = "PUT";
    /**
     *
     */
    const DELETE = "DELETE";

    /**
     * GuzzleService constructor.
     */
    function __construct()
    {
        $this->client = new Client([
            'verify' => false,
            'handler' => GuzzleLogObserver::getObserver()
        ]);
    }

    /**
     * @param StorageRequest $request
     */
    public function getRequest(StorageRequest $request)
    {
        $this->httpRequest(self::GET, $request);
    }

    /**
     * @param StorageRequest $request
     * @param string $method
     * @return \Psr\Http\Message\StreamInterface
     */
    public function multipartRequest(StorageRequest $request, $method = self::POST)
    {
        $request->setPayLoad('multipart');
        return $this->httpRequest($method, $request);
    }

    /**
     * @param StorageRequest $request
     * @param string $method
     * @return \Psr\Http\Message\StreamInterface
     */
    public function jsonRawRequest(StorageRequest $request, $method = self::POST)
    {
        $request->setPayLoad('json');
        return $this->httpRequest($method, $request);
    }

    /**
     * @param StorageRequest $request
     * @param string $method
     */
    public function formRequest(StorageRequest $request, $method = self::POST)
    {
        $request->setPayLoad('form_params');
        $this->httpRequest($method, $request);
    }

    /**
     * @param $method
     * @param StorageRequest $request
     * @return \Psr\Http\Message\StreamInterface
     * @throws BacktoryApiCallException
     */
    private function httpRequest($method, StorageRequest $request)
    {
        $options = ["headers" => $request->getHeaders()];
        if (!empty($request->getData())) {
            $options = array_merge(
                empty($request->generateRequestData()) ? [] : $request->generateRequestData(), $options
            );
        }

        try {
            $result = $this->client->request($method, $request->getUrl(), $options);

            if ($result->getStatusCode() >= 200 && $result->getStatusCode() < 230) {
                if ($request->getCallback() != null) {
                    $request->getCallback()->handle($this->generateStorageResponseObject($result));
                }

                if (!empty($request->getTransformer())) {
                    return $request->getTransformer()->transform($this->generateStorageResponseObject($result));
                }

                return $result->getBody();
            }
        } catch (Exception $exception) {
            throw new BacktoryApiCallException($exception->getMessage(), $exception->getCode());
        }
    }

    /**
     * @param ResponseInterface $response
     * @return StorageResponse
     */
    private function generateStorageResponseObject(ResponseInterface $response)
    {
        $storageResponse = new StorageResponse();
        $storageResponse->setBody(json_decode($response->getBody()));
        $storageResponse->setHeader($response->getHeaders());
        $storageResponse->setCode($response->getStatusCode());

        return $storageResponse;
    }
}