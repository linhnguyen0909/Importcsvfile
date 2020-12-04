<?php

namespace App\Services;

use phpDocumentor\Reflection\Types\ClassString;

class FileServiceBuilder
{
    public function build($fileType) {
        switch ($fileType) {
            case 'csv':
                return $this->buildCsvService();
            case 'xlsx':
                return $this->buildExcelService();
        }
    }
    public function buildCsvService() {
        return new CsvFileService(new FileService());
    }

    public function buildExcelService() {
        return new ExcelFileService();
    }

}
