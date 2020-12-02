<?php


namespace App\Services;


use Illuminate\Support\Facades\Validator;

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
        foreach ($array as $row){
            $attributes[] = array_combine($key,$row);
        }
        return $attributes;
    }
    public function validate (array $data):string {
        $rules = [
            'name' => 'required|min:4|max:50',
            'email' => 'required|email',
            'password' => 'required|min:8',
            'phone' => 'nullable|integer'
        ];
        $errors = [];
       foreach ($data as $key => $value){
           $validator = Validator::make($value,$rules);
           if ($validator->fails()){
               dd($validator->errors());
              $errors[$key]=$validator->errors();
           }
       }
       return '';

    }

}
