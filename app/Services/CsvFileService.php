<?php


namespace App\Services;


use Exception;
use Illuminate\Support\Facades\Validator;
use function PHPUnit\Framework\throwException;

/**
 * Class CsvFileService
 * @package App\Services
 */
class CsvFileService extends FileService
{
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
     * @param  array  $row
     * @return array
     */
    public function validate(array $row): array
    {
        $rules = [
            'name' => 'required|min:4|max:50',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'phone' => 'nullable|string|regex:/(03|07|08|09|01[2|6|8|9])+([0-9]{8})\b/'
        ];
        $validator = Validator::make($row, $rules);
        $errors = [];
        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();
        }
        return $errors;
    }

    /**
     * @param  array  $rows
     * @return array
     */
    public function validateMultiRow(array $rows): array
    {
        $errors = [];
        foreach ($rows as $key => $value) {
            $error = $this->validate($value);
            if (!empty($error)) {
                $errors[] = [
                    'line' => $key + 2,
                    'errors' => $error,
                ];
            }
        }
        return $errors;
    }

    /**
     * @param  string  $fileName
     * @return array
     * @throws Exception
     */
    public function parseWithHeaderFromFile(string $fileName)
    {

        $fileContent = $this->readContent($fileName);
        if ($fileContent === '') {
            throw new Exception();
        } else {
            $parseFile = $this->parseWithHeader($fileContent);
            return $parseFile;
        }
    }

}
