<?php

class FileService
{
    const FILE_APPEND = true;
    private $basePath;

    public function __construct($basePath)
    {
        $this->basePath = realpath($basePath);
        if ($this->basePath === false) {
            throw new Exception('Path unavailable: ' . $basePath);
        }
        $this->basePath .= '/';
    }

    protected function getRealPath(string $path): string
    {
        $fullPath = realpath($this->basePath . $path)
            ? realpath($this->basePath . $path)
            : realpath($this->basePath . dirname($path)) . '/' . basename($path);
        if ($fullPath && strpos($fullPath, realpath($this->basePath)) === 0) {
            return $fullPath;
        }

        throw new Exception('Unavailable ressource: ' . $path);
    }

    public function getFileContent($filename): string
    {
        $filePath = $this->getRealPath($filename);

        if (is_readable($filePath)) {
            return file_get_contents($filePath);
        }
        throw new Exception('Unreable file: ' . $filename);
    }

    public function listFiles(string $path): array
    {
        $files = [];

        $realPath = $this->getRealPath($path);

        if ($realPath && !is_readable($realPath)) {
            throw new Exception($path . ' is not readable.');
        }

        $directory = new DirectoryIterator($realPath);

        foreach ($directory as $fileInfo) {
            if (!$fileInfo->isDot()) {
                $files[] = $fileInfo->getFilename();
            }
        }

        return $files;
    }

    public function write(string $filename, string $content, bool $append = false): void
    {
        $filePath = $this->getRealPath($filename);

        if (
            (file_exists($filePath) && !is_writable($filePath))
            &&
            !is_writable(dirname($filePath))
        ) {
            throw new Exception('File ' . $filename . ' cannot be writen.');
        }

        file_put_contents($filePath, $content, $append ? FILE_APPEND : 0);
    }

    public function read(string $path): string|array
    {
        $realPath = $this->getRealPath($path);

        return is_dir($realPath) ? $this->listFiles($path) : $this->getFileContent($path);
    }

    public function makedir(string $path): void
    {
        mkdir($this->getRealPath(dirname($path)).'/'.basename($path));
    }

    public function create(string $path, $content = null): void
    {
        is_null($content) ? $this->makedir($path) : $this->write($path, $content);
    }

    public function delete(string $path): void
    {
        $realPath = $this->getRealPath($path);

        $fn = is_dir($realPath) ? 'rmdir' : 'unlink';

        if (!$fn($realPath)) {
            throw new Exception('Delete of '.$path.' failed.');
        }
    }
}