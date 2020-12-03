<?php

namespace App\Services;

use App\Models\User;
use Exception;

class FileService
{
    /**
     * @param  string  $fileName  The filename will be read
     * @return string The content of file
     * @throws Exception
     */
    public function read(string $fileName): string
    {
        // kiem tra file ton tai
        if (!file_exists($fileName)) {
            throw new  Exception();
        }
        // doc file neu ton tai
        $fopen = fopen($fileName, 'r');
        $content = '';
        while ($line = fgets($fopen)) {
            $content = $content.$line;
        }
        // dua ra noi dung file
        return $content;
    }

    /**
     * @param  string  $fileName
     * @return string
     * @throws Exception
     */
    public function readContent(string $fileName): string
    {
        if (!file_exists($fileName)) {
            throw new  Exception();
        }
        return file_get_contents($fileName);
    }

    public function import(array $parsedFile)
    {
        foreach ($parsedFile as $row) {
            $user = new User();
            $user->fill($row);
            $user->save();
        }
        //User::query()->create($parsedFile);
    }
}
