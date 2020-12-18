<?php

namespace App\Services;

use App\Models\User;
use Exception;

class FileService
{
    /**
     * @param  string  $fileName
     * @return string
     * @throws Exception
     */
    public function read(string $fileName): string
    {
        if (!file_exists($fileName)) {
            throw new  Exception();
        }
        return file_get_contents($fileName);
    }

}
