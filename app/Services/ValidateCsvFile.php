<?php


namespace App\Services;



use Illuminate\Support\Facades\Validator;

class ValidateCsvFile
{
    public function validate (array $data):array {
        $rules = [
            "name" => "required|min:4|max:50",
            "email" => "required|email",
            "password" => "required|min:8",
            "phone" => "nullable|integer"
        ];
        $validator = validator::make($data,$rules);
        if ($validator->failed()){
            throw \Exception();
        }else {
            return $data;
        }
    }
}
