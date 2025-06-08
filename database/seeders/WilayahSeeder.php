<?php

namespace Database\Seeders;

use App\Models\Wilayah;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;

/**
 * Class WilayahSeeder
 *
 * Seeds the wilayah table with data from wilayahData.xlsx.
 */
class WilayahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Path to the Excel file in storage/app
        $filePath = storage_path('app/wilayahData.xlsx');

        // Load the Excel file and process each row
        Excel::import(new class implements \Maatwebsite\Excel\Concerns\ToCollection {
            public function collection(\Illuminate\Support\Collection $rows)
            {
                // Skip the header row
                $rows->shift();

                foreach ($rows as $row) {
                    Wilayah::create([
                        'provinsi' => $row[0],
                        'kota' => $row[1],
                    ]);
                }
            }
        }, $filePath);
    }
}
