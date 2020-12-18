<?php


namespace App\Services\Abstracts;


abstract class ParseFile
{
    abstract function parse(string $data): array;
    abstract function parseWithHeader(string $content): array;
    abstract function parseWithHeaderFromFile(string $fileName): array;
}
