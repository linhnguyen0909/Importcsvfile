<?php


namespace App\Services;


use Exception;
use Illuminate\Support\Facades\Validator;
use function PHPUnit\Framework\throwException;

class CsvFileService extends FileService
{
    public function parse(string $data): array {
        // format data before parse
        $data = trim($data);
        // doc tung dong
        foreach(preg_split("/((\r?\n)|(\r\n?))/", $data) as $line){
            // tach ra tung cot theo tung dong
           $content[]=explode(',',$line); ;
        }
        // chuyen array sang key value
        return $content;
    }
    public function parseWithHeader(string $content):array {
        // parse to array
        $array = $this->parse($content);
        // get header row
        $key = array_values(array_shift($array));
        // transform data with header
        $attributes = [];
        foreach ($array as $row){
            $attributes[] = array_combine($key,$row);
        }
        return $attributes;
    }
    public function validate (array $row):array {
        $rules = [
            'name' => 'required|min:4|max:50',
            'email' => 'required|email',
            'password' => 'required|min:8',
            'phone' => 'nullable|integer'
        ];
       $validator = Validator::make($row, $rules);
        $errors = [];
       if ($validator->fails()){
          $errors =$validator->errors()->toArray();
       }
       return $errors;
    }
    public function validateMultiRow(array $rows):array {
        $errors = [];
        foreach ($rows as $key => $value) {
            $error = $this->validate($value);
            if (!empty($error)) {
                $errors[$key+2] = $error;
            }
        }
        return $errors;
    }
    public function parseWithHeaderFromFile(string $fileName){

        $fileContent = $this->readContent($fileName);
        if ($fileContent===''){
            throw new Exception();
        }else {
            $parseFile = $this->parseWithHeader($fileContent);
            return $parseFile;
        }
    }

}
