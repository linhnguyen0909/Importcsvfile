<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImportFileRequest;
use App\Models\User;
use App\Services\DataValidationService;
use App\Services\FileServiceBuilder;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

/**
 * Class ImportFileController
 * @package App\Http\Controllers
 */
class ImportFileController extends Controller
{
    /**
     * @var FileServiceBuilder
     */
    private $fileServiceBuilder;

    /**
     * ImportFileController constructor.
     * @param  FileServiceBuilder  $fileServiceBuilder
     */
    public function __construct(FileServiceBuilder $fileServiceBuilder)
    {
        $this->fileServiceBuilder = $fileServiceBuilder;
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function importFile()
    {
        return view('import-file');
    }

    /**
     * @param  ImportFileRequest  $request
     * @param  DataValidationService  $dataValidationService
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function import(ImportFileRequest $request,DataValidationService $dataValidationService)
    {
        $file = $request->file('file');
        // get extention file
        $fileExtension = $file->getClientOriginalExtension();
        $dataFileService = $this->fileServiceBuilder->build($fileExtension);
        $parseFile = $dataFileService->parseWithHeaderFromFile($file);
        $this->actionDataFile($parseFile,$dataValidationService);
        return redirect()->back();
    }

    /**
     * @param $parseFile
     * @param  DataValidationService  $dataValidationService
     */
    public function actionDataFile($parseFile,DataValidationService $dataValidationService){
        $validateParseFile = $dataValidationService->validateMultiRow($parseFile);
        if (empty($validateParseFile)) {
            foreach ($parseFile as $row) {
                $user = new User();
                $user->fill($row);
                $user->save();
            }
        } else {
            throw new BadRequestException('no import');
        }
    }
}
