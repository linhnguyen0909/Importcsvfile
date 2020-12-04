<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImportFileRequest;
use App\Models\User;
use App\Services\CsvFileService;
use App\Services\DataValidationService;
use App\Services\ExcelFileService;
use App\Services\FileService;
use App\Services\FileServiceBuilder;
use Illuminate\Http\Request;

class ImportFileController extends Controller
{
    private $fileServiceBuilder;

    public function __construct(FileServiceBuilder $fileServiceBuilder)
    {
        $this->fileServiceBuilder = $fileServiceBuilder;
    }

    public function importFile()
    {
        return view('import-file');
    }

    public function import(ImportFileRequest $request,DataValidationService $dataValidationService)
    {
        $file = $request->file('file');
        // get extention file
        $fileExtension = $file->getClientOriginalExtension();
        $dataFileService = $this->fileServiceBuilder->build($fileExtension);
        $parseFile = $dataFileService->parseWithHeaderFromFile($file);
        $validateParseFile = $dataValidationService->validateMultiRow($parseFile);
        if (empty($validateParseFile)) {
            foreach ($parseFile as $row) {
                $user = new User();
                $user->fill($row);
                $user->save();
            }
            dd('success');
        } else {

        }
    }
}
