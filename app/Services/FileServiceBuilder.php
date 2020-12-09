<?php

namespace App\Services;

use phpDocumentor\Reflection\Types\ClassString;

class FileServiceBuilder
{
    /**
     * @param $fileType
     * @return CsvFileService|ExcelFileService
     */
    public function build($fileType) {
        switch ($fileType) {
            case 'csv':
                return $this->buildCsvService();
            case 'xlsx':
                return $this->buildExcelService();
        }
    }

    /**
     * @return CsvFileService
     */
    public function buildCsvService() {
        return new CsvFileService(new FileService());
    }

    /**
     * @return ExcelFileService
     */
    public function buildExcelService() {
        return new ExcelFileService(new FileService());
    }

}
