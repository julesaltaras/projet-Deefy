<?php

namespace deefy\autoload;

class Autoloader
{
    private string $prefix;
    private string $baseDir;

    public function __construct(string $prefix = 'iutnc\\deefy\\', string $baseDir = __DIR__ . '/..')
    {
        $this->prefix  = rtrim($prefix, '\\') . '\\';
        $this->baseDir = rtrim($baseDir, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
    }

    public function register(): void
    {
        spl_autoload_register([$this, 'loadClass']);
    }

    public function loadClass(string $class): void
    {
        // on ne charge que notre namespace
        if (strpos($class, $this->prefix) !== 0) {
            return;
        }

        $relative = substr($class, strlen($this->prefix));
        $file = $this->baseDir . str_replace('\\', DIRECTORY_SEPARATOR, $relative) . '.php';

        if (is_file($file)) {
            require $file;
        }
    }
}
