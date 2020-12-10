<?php


namespace App\Services;


use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class UserImport implements ToModel, WithHeadingRow, WithValidation
{

    /**
     * @inheritDoc
     */
    public function model(array $row)
    {
        return new User([
            'name' => $row['name'],
            'email' => $row['email'],
            'password' => $row['password'],
            'phone' => $row['phone'],
        ]);


    }

    public function rules(): array
    {
        return [
            "name" => "required|min:4|max:50",
            "email" => "required|email",
            "password" => "required|min:8",
            "phone" => "nullable|integer"
        ];
    }
}
