<?php

class Service_Excel
{
    static public function dump($path)
    {
        $excel = PHPExcel_IOFactory::createReader('Excel2007');
        $book = $excel->load($path);
        $sheet = $book->getActiveSheet();
        return $sheet->toArray(null, true, true, true);
    }
}
