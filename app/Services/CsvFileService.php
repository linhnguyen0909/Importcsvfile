<?php


namespace App\Services;

use App\Services\Abstracts\ParseFile;
use Exception;
use Illuminate\Support\Facades\Validator;

/**
 * Class CsvFileService
 * @package App\Services
 */
class CsvFileService extends ParseFile
{
    private $fileService;
    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }
    /**
     * @param  string  $data
     * @return array
     */
    public function parse(string $data): array
    {
        // format data before parse
        $data = trim($data);
        // doc tung dong
        foreach (preg_split("/((\r?\n)|(\r\n?))/", $data) as $line) {
            // tach ra tung cot theo tung dong
            $content[] = explode(',', $line);;
        }
        // chuyen array sang key value
        return $content;
    }

    /**
     * @param  string  $content
     * @return array
     */
    public function parseWithHeader(string $content): array
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
    public function parseWithHeaderFromFile(string $fileName): array
    {
        $fileContent = $this->fileService->read($fileName);
        if ($fileContent === '') {
            throw new Exception();
        } else {
            $parseFile = $this->parseWithHeader($fileContent);
            return $parseFile;
        }
    }

}
