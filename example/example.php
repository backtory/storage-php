<?php
include "../vendor/autoload.php";

use Backtory\Storage\Core\Facade\BacktoryStorage;

BacktoryStorage::initWithConfigFile("config.yml"); // supported config formats: .ini, .php, .xml, .json, .yml
// or
BacktoryStorage::init("BacktoryAuthenticationId", "BacktoryAuthenticationKey", "xBacktoryObjectStorageId");


// headers and parameters
BacktoryStorage::setHeader(["h1" => "v1"]);
BacktoryStorage::setParameters(["p1" => "v1"]);
BacktoryStorage::addHeader("h2", "v2");
BacktoryStorage::addParameter("p1", "v2");


// directories
BacktoryStorage::createDirectory("dir1");
BacktoryStorage::directoryInfo("dir1");


// files
BacktoryStorage::put("/home/root/docs/file1.txt", "dir1"); //file resource or file path
BacktoryStorage::putFiles([
    [
        "file" => "/home/root/docs/file2.txt",
        "path" => "dir2"
    ],
    [
        "file" => fopen("/home/root/docs/file3.txt", 'r'),
        "path" => "tmp"
    ]
]);

BacktoryStorage::fileInfo("dir1/file1.txt");

BacktoryStorage::copy("dir1/file1.txt", "tmp");
BacktoryStorage::copy(["dir1/file1.txt", "dir2/file2.txt"], "tmp");

BacktoryStorage::move("dir1/file1.txt", "tmp");
BacktoryStorage::move(["dir1/file1.txt", "dir2/file2.txt"], "tmp");

BacktoryStorage::delete("dir1/file1.txt");

BacktoryStorage::rename("dir1/file1.txt", "newFile.txt");
BacktoryStorage::renameFiles([
    ["dir1/file1.txt", "newFile1.txt"],
    ["dir2/file2.txt", "newFile2.txt"]
]);

BacktoryStorage::exists("/dir1/test.txt");

BacktoryStorage::url("dir1/file.txt");

// download
$content = BacktoryStorage::get("/dir1/file1.txt");
BacktoryStorage::get("/dir1/file1.txt", "/local/path");

// also we can use this functions like below
BacktoryStorage::initWithConfigFile("config.yml")
    ->url("dir1/file.txt");