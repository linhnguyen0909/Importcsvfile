<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImportFileRequest;
use App\Mail\MyEmail;
use App\Models\User;
use App\Services\DataValidationService;
use App\Services\FileServiceBuilder;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
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
        if($request->hasFile('file')){
            $file = $request->file('file');
            $fileExtension = $file->getClientOriginalExtension();
        }else{
            $file = $request->get('file_path');
            $fileExtension = pathinfo($request->file_path,PATHINFO_EXTENSION);
        }
        $dataFileService = $this->fileServiceBuilder->build($fileExtension);
        $parseFile = $dataFileService->parseWithHeaderFromFile($file);
        $this->actionDataFile($parseFile,$dataValidationService);
        return back()->with('status', 'successfully!');
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
                $this->sendEmail($row['email']);
            }
        } else {
            throw new Exception("ERROR".json_encode($validateParseFile));
        }
    }
    public function sendEmail($request)
    {
        Mail::to($request)->send(new MyEmail('123123123'));
    }
}
