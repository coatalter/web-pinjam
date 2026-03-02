<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EquipmentSeeder extends Seeder
{
    public function run()
    {
        $equipment = [
            [
                'name' => 'Mikroskop Binokuler',
                'code' => 'MKB-001',
                'description' => 'Mikroskop binokuler untuk pengamatan sel dan jaringan',
                'category' => 'general',
                'is_available' => true,
                'condition' => 'baik',
            ],
            [
                'name' => 'Spektrofotometer UV-Vis',
                'code' => 'SPK-102',
                'description' => 'Spektrofotometer untuk analisis kuantitatif',
                'category' => 'water',
                'is_available' => true,
                'condition' => 'baik',
            ],
            [
                'name' => 'Oven Pengering',
                'code' => 'OVN-050',
                'description' => 'Oven laboratorium untuk sterilisasi dan pengeringan sampel',
                'category' => 'soil',
                'is_available' => true,
                'condition' => 'baik',
            ],
            [
                'name' => 'Centrifuge Micro',
                'code' => 'CEN-010',
                'description' => 'Microcentrifuge berkecepatan tinggi',
                'category' => 'general',
                'is_available' => true,
                'condition' => 'rusak_ringan',
            ],
            [
                'name' => 'pH Meter Mettler Toledo',
                'code' => 'PHM-300',
                'description' => 'Alat pengukur pH cairan presisi tinggi',
                'category' => 'water',
                'is_available' => true,
                'condition' => 'baik',
            ],
            [
                'name' => 'Autoclave 50L',
                'code' => 'ATC-500',
                'description' => 'Autoclave vertikal untuk sterilisasi basah',
                'category' => 'general',
                'is_available' => true,
                'condition' => 'baik',
            ],
            [
                'name' => 'Kjeldahl Digestion Unit',
                'code' => 'KJD-112',
                'description' => 'Alat destruksi protein/nitrogen pada sampel tanah dan tanaman',
                'category' => 'soil',
                'is_available' => true,
                'condition' => 'baik',
            ],
            [
                'name' => 'Atomic Absorption Spectrophotometer (AAS)',
                'code' => 'AAS-210',
                'description' => 'AAS untuk analisis logam berat',
                'category' => 'water',
                'is_available' => true,
                'condition' => 'baik',
            ],
            [
                'name' => 'Gas Chromatography (GC)',
                'code' => 'GC-405',
                'description' => 'GC untuk analisis senyawa volatil',
                'category' => 'general',
                'is_available' => true,
                'condition' => 'baik',
            ],
            [
                'name' => 'Leaf Area Meter',
                'code' => 'LAM-800',
                'description' => 'Alat ukur luas daun non-destruktif',
                'category' => 'plant_tissue',
                'is_available' => true,
                'condition' => 'baik',
            ],
        ];

        foreach ($equipment as $item) {
            $item['created_at'] = now();
            $item['updated_at'] = now();
            DB::table('equipment')->insert($item);
        }
    }
}
