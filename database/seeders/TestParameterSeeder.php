<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TestParameterSeeder extends Seeder
{
    public function run()
    {
        $parameters = [
            // Tanah
            ['name' => 'pH H2O', 'unit' => '-', 'method' => 'Elektrometri', 'category' => 'soil', 'price' => 50000, 'is_active' => true],
            ['name' => 'C-Organik', 'unit' => '%', 'method' => 'Walkley & Black', 'category' => 'soil', 'price' => 75000, 'is_active' => true],
            ['name' => 'N-Total', 'unit' => '%', 'method' => 'Kjeldahl', 'category' => 'soil', 'price' => 100000, 'is_active' => true],
            ['name' => 'P-Tersedia (Bray I)', 'unit' => 'ppm', 'method' => 'Spektrofotometri', 'category' => 'soil', 'price' => 85000, 'is_active' => true],
            ['name' => 'K-dd', 'unit' => 'cmol(+)/kg', 'method' => 'Ekstraksi NH4OAc', 'category' => 'soil', 'price' => 80000, 'is_active' => true],
            ['name' => 'KTK', 'unit' => 'cmol(+)/kg', 'method' => 'Ekstraksi NH4OAc', 'category' => 'soil', 'price' => 120000, 'is_active' => true],
            ['name' => 'Tekstur (Pasir, Debu, Liat)', 'unit' => '%', 'method' => 'Pipet/Hidrometer', 'category' => 'soil', 'price' => 150000, 'is_active' => true],

            // Air
            ['name' => 'pH Air', 'unit' => '-', 'method' => 'Elektrometri', 'category' => 'water', 'price' => 45000, 'is_active' => true],
            ['name' => 'BOD (Biochemical Oxygen Demand)', 'unit' => 'mg/L', 'method' => 'Inkubasi 5 Hari', 'category' => 'water', 'price' => 150000, 'is_active' => true],
            ['name' => 'COD (Chemical Oxygen Demand)', 'unit' => 'mg/L', 'method' => 'Refluks Terbuka/Tertutup', 'category' => 'water', 'price' => 160000, 'is_active' => true],
            ['name' => 'Total Suspended Solid (TSS)', 'unit' => 'mg/L', 'method' => 'Gravimetri', 'category' => 'water', 'price' => 60000, 'is_active' => true],
            ['name' => 'Amonia (NH3-N)', 'unit' => 'mg/L', 'method' => 'Fenat', 'category' => 'water', 'price' => 90000, 'is_active' => true],
            ['name' => 'Timbal (Pb)', 'unit' => 'mg/L', 'method' => 'AAS', 'category' => 'water', 'price' => 135000, 'is_active' => true],
            ['name' => 'Tembaga (Cu)', 'unit' => 'mg/L', 'method' => 'AAS', 'category' => 'water', 'price' => 135000, 'is_active' => true],
            ['name' => 'Coliform Total', 'unit' => 'MPN/100mL', 'method' => 'MPN', 'category' => 'water', 'price' => 125000, 'is_active' => true],

            // Jaringan Tanaman
            ['name' => 'Kadar Air', 'unit' => '%', 'method' => 'Gravimetri', 'category' => 'plant_tissue', 'price' => 50000, 'is_active' => true],
            ['name' => 'N-Daun', 'unit' => '%', 'method' => 'Kjeldahl Destruksi', 'category' => 'plant_tissue', 'price' => 110000, 'is_active' => true],
            ['name' => 'P-Daun', 'unit' => '%', 'method' => 'Destruksi Basah - Spektro', 'category' => 'plant_tissue', 'price' => 110000, 'is_active' => true],
            ['name' => 'K-Daun', 'unit' => '%', 'method' => 'Destruksi Basah - AAS/Flame', 'category' => 'plant_tissue', 'price' => 110000, 'is_active' => true],
            ['name' => 'Kalsium (Ca) Daun', 'unit' => '%', 'method' => 'AAS', 'category' => 'plant_tissue', 'price' => 120000, 'is_active' => true],
            ['name' => 'Magnesium (Mg) Daun', 'unit' => '%', 'method' => 'AAS', 'category' => 'plant_tissue', 'price' => 120000, 'is_active' => true],
            ['name' => 'Klorofil a & b', 'unit' => 'mg/g', 'method' => 'Ekstraksi Alkohol + Spektro', 'category' => 'plant_tissue', 'price' => 95000, 'is_active' => true],
        ];

        foreach ($parameters as $item) {
            $item['created_at'] = now();
            $item['updated_at'] = now();
            DB::table('test_parameters')->insert($item);
        }
    }
}
