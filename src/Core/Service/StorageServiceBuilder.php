<?php
namespace Backtory\Storage\Core\Service;

use Backtory\Storage\Adapters\HttpClient\Guzzle\GuzzleHttpClientAdapter;

/**
 * Class StorageServiceBuilder
 * @package Backtory\Storage\Core\Service
 */
class StorageServiceBuilder
{
    /**
     * @var
     */
    private $instanceId;
    /**
     * @var
     */
    private $authenticationId;
    /**
     * @var
     */
    private $authenticationKey;
    /**
     * @var
     */
    private $parameters = [];
    /**
     * @var
     */
    private $headers = [];

    /**
     * StorageServiceBuilder constructor.
     */
    private function __construct()
    {
    }

    /**
     * @return StorageService
     */
    public static function getInstance()
    {
        return StorageService::getInstance();
    }

    /**
     * @return StorageServiceBuilder
     */
    public static function builder()
    {
        return new StorageServiceBuilder();
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
     * @return mixed
     */
    public function getAuthenticationId()
    {
        return $this->authenticationId;
    }

    /**
     * @param mixed $authenticationId
     * @return $this
     */
    public function setAuthenticationId($authenticationId)
    {
        $this->authenticationId = $authenticationId;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getAuthenticationKey()
    {
        return $this->authenticationKey;
    }

    /**
     * @param mixed $authenticationKey
     * @return $this
     */
    public function setAuthenticationKey($authenticationKey)
    {
        $this->authenticationKey = $authenticationKey;

        return $this;
    }


    /**
     * @param mixed $parameters
     * @return $this
     */
    public function setParameters(array $parameters)
    {
        $this->parameters = $parameters;

        return $this;
    }

    /**
     * @param mixed $headers
     * @return $this
     */
    public function setHeaders(array $headers)
    {
        $this->headers = $headers;

        return $this;
    }

    /**
     * @return StorageService
     */
    public function build()
    {
        $instance = StorageService::getInstance(new GuzzleHttpClientAdapter())
            ->setInstanceId($this->instanceId);

        $instance->auth($this->getAuthenticationId(), $this->getAuthenticationKey());

        $instance->setParameters($this->parameters)
            ->setHeaders($this->headers);

        return $instance;
    }
}