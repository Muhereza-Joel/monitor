<?php

namespace core\cache;

use Psr\SimpleCache\CacheInterface;

class FileCache implements CacheInterface
{
    private $cacheDir;

    public function __construct($cacheDir = '/tmp')
    {
        $this->cacheDir = rtrim($cacheDir, '/');
        $this->ensureCacheDirExists();
    }

    private function ensureCacheDirExists()
    {
        if (!is_dir($this->cacheDir)) {
            mkdir($this->cacheDir, 0777, true);
        }
    }

    public function get($key, $default = null)
    {
        $filePath = $this->getFilePath($key);
        if (file_exists($filePath)) {
            return unserialize(file_get_contents($filePath));
        }
        return $default;
    }

    public function set($key, $value, $ttl = null)
    {
        $filePath = $this->getFilePath($key);
        file_put_contents($filePath, serialize($value));
    }

    public function delete($key)
    {
        $filePath = $this->getFilePath($key);
        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }

    private function getFilePath($key)
    {
        return $this->cacheDir . '/' . md5($key) . '.cache';
    }

    public function getMultiple($keys, $default = null) {}

    public function setMultiple($values, $ttl = null) {}

    public function deleteMultiple($keys) {}

    public function clear() {}

    public function has($key) {}
}
