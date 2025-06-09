<?php

namespace Database\Seeders;

use App\Models\Wilayah;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;

class WilayahSeeder extends Seeder
{
    public function run()
    {
        $filePath = public_path('wilayahData.xlsx');

        Excel::import(new class implements \Maatwebsite\Excel\Concerns\ToCollection {
            public function collection(\Illuminate\Support\Collection $rows)
            {
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
