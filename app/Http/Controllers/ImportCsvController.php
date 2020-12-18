<?php

namespace App\Http\Controllers;

use App\Services\CsvFileService;
use App\Services\FileService;
use Illuminate\Http\Request;

class ImportCsvController extends Controller
{
    public function importCsvFile()
    {
        return view('import-file');
    }

    public function csvFile()
    {
        $csvFileService = new CsvFileService();
        $parseFile = $csvFileService->parseWithHeaderFromFile('C:\Users\Admin\Desktop\Book_null.csv');
        $validateParseFile = $csvFileService->validateMultiRow($parseFile);
        if (empty($validateParseFile)) {
            $csvFileService->import($parseFile);
//            return view('success');
        }else {
           return view('error');
        }
    }
}
