<?php
require "./Classes/Movie.php";
require './vendor/autoload.php';

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=movieApp.csv');

$csv = Movie::getCSVExport();
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Csv;


$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();


$x = 'A';

foreach ($csv as $key => $c)
{
    # Get keys and create headers
    $sheet->setCellValue( $x ."1", $key);

    $i=2;
    foreach ($c as $value){
     # Fill CSV with values
            $sheet->setCellValue( $x .$i, $value);
        $i++;
    }

    $x++;
}


$writer = new Csv($spreadsheet);
$writer->save('php://output');


// create a file pointer connected to the output stream
$output = fopen('php://output', 'w');
