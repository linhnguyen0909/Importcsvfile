<?php


namespace App\Services;


use App\Services\Abstracts\ParseFile;
use Maatwebsite\Excel\Excel;
use Rap2hpoutre\FastExcel\Facades\FastExcel;

class ExcelFileService extends ParseFile
{

    function parse(string $data): array
    {
        // TODO: Implement parseWithHeader() method.
    }

    function parseWithHeader(string $content): array
    {
        // TODO: Implement parseWithHeader() method.
    }

    function parseWithHeaderFromFile(string $fileName): array
    {
        dd($fileName);
        return FastExcel::import($fileName)->toArray();
    }
}
