<?php

namespace App\Http\Controllers;

use App\Services\CsvFileService;
use App\Services\FileService;
use Illuminate\Http\Request;

class ImportCsvController extends Controller
{
    public function importCsvFile(){
        return view('import-file');
    }
    public function csvFile() {
//        $fileService = new FileService();
//        $content = $fileService->read('C:\\Book1.csv');
        $csvFileService = new CsvFileService();
        $content = $csvFileService->read('C:\\Book1.csv');
        $data = $csvFileService->parseWithHeader($content);
        $datavalidate=$csvFileService->validate($data);
        print_r($datavalidate);
    }
}
