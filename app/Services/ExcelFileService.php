<?php


namespace App\Services;


use App\Services\Abstracts\ParseFile;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Csv;


/**
 * Class ExcelFileService
 * @package App\Services
 */
class ExcelFileService extends ParseFile
{
    /**
     * @var FileService
     */
    private $fileService;

    /**
     * ExcelFileService constructor.
     * @param  FileService  $fileService
     */
    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }

    /**
     * @param  string  $data
     * @return array
     */
    function parse(string $data): array
    {   // parse string data to array
        $filedata = \SimpleXLSX::parseData($data)->rows();
        return $filedata;
    }

    /**
     * @param  string  $content
     * @return array
     */
    function parseWithHeader(string $content): array
    {
        // parse to array
        $array = $this->parse($content);
        // get header row
        $key = array_values(array_shift($array));
        // transform data with header
        $attributes = [];
        foreach ($array as $row) {
            $attributes[] = array_combine($key, $row);
        }
        return $attributes;
    }

    /**
     * @param  string  $fileName
     * @return array
     * @throws Exception
     */
    function parseWithHeaderFromFile(string $fileName): array
    {
        $fileContent = $this->fileService->read($fileName);
        if ($fileContent === '') {
            throw new Exception('No file');
        } else {
            $parseFile = $this->parseWithHeader($fileContent);
            return $parseFile;
        }
    }
}
