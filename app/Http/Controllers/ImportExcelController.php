<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Excel;
use Rap2hpoutre\FastExcel\FastExcel;

class ImportExcelController extends Controller
{
    public function     importFileExcel()
    {
        (new FastExcel)->import('C:\Users\Admin\Desktop\Book1.xlsx', function ($line) {
//            return User::create([
//                'name' => $line['name'],
//                'email' => $line['email'],
//                'password' => $line['password'],
//                'phone' => $line['phone'],
//            ]);
dd($line);
        });
    }

    public function read()
    {
        Excel::load('C:\Users\Admin\Desktop\Book1.xlsx', function ($reader) {
//            // Getting all results
//            $results = $reader->get();

            // ->all() is a wrapper for ->get() and will work the same
            $results = $reader->all();
            dd($results);
        });
    }
}
