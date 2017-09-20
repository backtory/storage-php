<?php
namespace Backtory\Storage\Core\Requests;

use Backtory\Storage\Core\Interfaces\ResponseTransformer;
use Backtory\Storage\Core\Interfaces\StorageResponseCallback;

/**
 * Class StorageRequest
 * @package Backtory\Storage\Core\Model
 */
abstract class StorageRequest
{

    /**
     * @var
     */
    protected $headers = [];
    /**
     * @var
     */
    protected $params = [];
    /**
     * @var
     */
    protected $data = [];
    /**
     * @var
     */
    protected $callback;
    protected $payLoad;
    protected $transformer;

    /**
     * @return mixed
     */
    public function getTransformer()
    {
        return $this->transformer;
    }

    /**
     * @param mixed $transformer
     * @return $this
     */
    public function setTransformer(ResponseTransformer $transformer)
    {
        $this->transformer = $transformer;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPayLoad()
    {
        return $this->payLoad;
    }

    /**
     * @param mixed $payLoad
     * @return $this
     */
    public function setPayLoad($payLoad)
    {
        $this->payLoad = $payLoad;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCallback()
    {
        return $this->callback;
    }

    /**
     * @param mixed $callback
     * @return $this
     */
    public function setCallback(StorageResponseCallback $callback = null)
    {
        $this->callback = $callback;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @param mixed $headers
     * @return $this
     */
    public function setHeaders($headers)
    {
        $this->headers = $headers;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * @param mixed $params
     * @return $this
     */
    public function setParams($params)
    {
        $this->params = $params;

        return $this;
    }

    /**
     * @param $data
     * @return $this
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }


    public function getUrl()
    {
        $path = $this->getUri();
        if (empty($this->getParams())) {
            return $path;
        }

        $params = http_build_query($this->getParams());

        if (strpos($path, "?") > 0) {
            return $path . $params;
        } else {
            return $path . "?" . $params;
        }
    }


    /**
     * @return mixed
     */
    function getData()
    {
        return $this->data;
    }

    abstract function generateRequestData();

    /**
     * @return mixed
     */
    abstract protected function getUri();
}