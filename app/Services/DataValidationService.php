<?php


namespace App\Services;


use Illuminate\Support\Facades\Validator;

class DataValidationService
{
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
            'phone' => 'nullable|string'
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
}
