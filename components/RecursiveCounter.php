<?php

namespace app\components;

class RecursiveCounter
{
    private string $path;

    public function __construct(string $path)
    {
        $this->path = $path;
    }

    /**
     * Get the sum of all numbers from files named "count" in a directory
     * @return int
     */
    public function getSum(): int
    {
        $sum = 0;

        $directory = new \RecursiveDirectoryIterator($this->path, \FilesystemIterator::FOLLOW_SYMLINKS);
        $filter = new \RecursiveCallbackFilterIterator($directory, function ($current, $key, $iterator) {
            if ($iterator->hasChildren()) {
                return TRUE;
            }

            return $current->isFile() && $current->getFilename() == 'count';
        });

        $iterator = new \RecursiveIteratorIterator($filter);

        foreach ($iterator as $info) {
            $sum += $this->getSumFromFile($info->getPathname());
        }

        return $sum;
    }

    /**
     * Get sum of numbers from file
     * @param string $pathName
     *
     * @return int
     */
    private function getSumFromFile(string $pathName): int
    {
        $fileContent = file_get_contents($pathName);

        //Use getting numbers through a regular expression, if there are several in the file and they can be separated by other characters
        return array_sum(preg_split('/\D/', $fileContent));
    }
}
