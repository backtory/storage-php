<?php
namespace Backtory\Storage\Core\Contract;

/**
 * Class BacktoryApiUrl
 * @package Backtory\Storage\Core\Contract
 */
class BacktoryApiUrl
{
    /**
     *
     */
    const LOGIN_URL = ApplicationConfig::BACKTORY_BASE_URL . "/auth/login";
    /**
     *
     */
    const UPLOAD_URI = ApplicationConfig::STORAGE_BASE_URL . "/files";
    /**
     *
     */
    const FILE_INFO_URI = ApplicationConfig::STORAGE_BASE_URL . "/files/fileInfo";
    /**
     *
     */
    const DIRECTORY_INFO_URI = ApplicationConfig::STORAGE_BASE_URL . "/files/directoryInfo";
    /**
     *
     */
    const DELETE_URI = ApplicationConfig::STORAGE_BASE_URL . "/files";
    /**
     *
     */
    const COPY_URI = ApplicationConfig::STORAGE_BASE_URL . "/files/copy";
    /**
     *
     */
    const CREATE_DIRECTORY = ApplicationConfig::STORAGE_BASE_URL . "/directories";
    /**
     *
     */
    const RENAME_URI = ApplicationConfig::STORAGE_BASE_URL . "/files/rename";
    /**
     *
     */
    const CUT_URI = ApplicationConfig::STORAGE_BASE_URL . "/files/move";

}