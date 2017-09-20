<?php
namespace Backtory\Storage\Core\Responses;

/**
 * Class StorageResponse
 * @package Backtory\Storage\Core\Responses
 */
class StorageResponse
{
    /**
     * @var
     */
    private $code;
    /**
     * @var
     */
    private $body;
    /**
     * @var
     */
    private $header;

    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param mixed $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }

    /**
     * @return mixed
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param mixed $body
     */
    public function setBody($body)
    {
        $this->body = $body;
    }

    /**
     * @return mixed
     */
    public function getHeader()
    {
        return $this->header;
    }

    /**
     * @param mixed $header
     */
    public function setHeader($header)
    {
        $this->header = $header;
    }


}