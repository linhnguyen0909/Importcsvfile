<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Excel;
use Rap2hpoutre\FastExcel\FastExcel;

class ImportExcelController extends Controller
{
    public function importFileExcel()
    {
        (new FastExcel)->import('C:\Users\Admin\Downloads\code501k.csv', function ($line) {
            User::query()->create($line);
        });
    }

    public function read()
    {
        //
    }
}
