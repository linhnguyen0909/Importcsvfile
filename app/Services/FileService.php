<?php

namespace App\Services;

class FileService
{
    public function read(string $fileName): string
    {
        // kiem tra file ton tai
        if (!file_exists($fileName)) {
            throw Exception();
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
}
