<?php

use Illuminate\Database\Seeder;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Models\Company;
use App\Models\DrugShape;

class DrugsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        echo getcwd() . "\n";
        $spreadsheet = IOFactory::load('./database/seeds/drugs.xlsx');
        $worksheet = $spreadsheet->getActiveSheet();
        // Get the highest row and column numbers referenced in the worksheet
        $highestRow = $worksheet->getHighestRow(); // e.g. 10
        $highestColumn = $worksheet->getHighestColumn(); // e.g 'F'
        $highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn); // e.g. 5

        for ($row = 2; $row <= $highestRow; ++$row) {
            for ($col = 2; $col <= $highestColumnIndex; ++$col) {
                if ($col == 2) {
                    $value = $worksheet->getCellByColumnAndRow($col, $row)->getValue();
                    $company_id = Company::select('id')->where('name', $value)->firstOrFail()->id;
                    $worksheet->getCellByColumnAndRow($col, $row)->setValue($company_id);
                } elseif ($col == 5) {
                    $value = $worksheet->getCellByColumnAndRow($col, $row)->getValue();
                    $shape_id = DrugShape::select('id')->where('name', $value)->firstOrFail()->id;
                    $worksheet->getCellByColumnAndRow($col, $row)->setValue($shape_id);
                } else {
                    continue;
                }
            }
        }

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save('./database/seeds/drugs-new.xlsx');
    }
}
