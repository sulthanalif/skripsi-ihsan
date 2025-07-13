<?php

namespace Database\Seeders;

use App\Models\DocumentType;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $documentType = new DocumentType();

        $suratKeteranganDomisili = $documentType->create([
            'name' => 'Surat Keterangan Domisili',
            'description' => 'Diperuntukan untuk keterangan domisili',
            'status' => true,
        ]);

        $suratKeteranganUsaha = $documentType->create([
            'name' => 'Surat Keterangan Usaha',
            'description' => 'Diperuntukan untuk keterangan usaha',
            'status' => true,
        ]);

        $suratKeteranganTidakMampu = $documentType->create([
            'name' => 'Surat Keterangan Tidak Mampu',
            'description' => 'Diperuntukan untuk keterangan tidak mampu',
            'status' => true,
        ]);


        $fields_suratKeteranganUsaha = [
            [
                'field_name' => 'jenis_usaha',
                'field_label' => 'Jenis Usaha',
                'field_type' => 'text',
                'field_options' => null,
                'field_checkbox_options' => null,
                'is_required' => 1,
                'order' => 1,
                'hint' => null,
            ],
            [
                'field_name' => 'alamat_usaha',
                'field_label' => 'Alamat Usaha',
                'field_type' => 'textarea',
                'field_options' => null,
                'field_checkbox_options' => null,
                'is_required' => 1,
                'order' => 2,
                'hint' => null,
            ],
            [
                'field_name' => 'lama_usaha',
                'field_label' => 'Lama Usaha (tahun/bulan)',
                'field_type' => 'text',
                'field_options' => null,
                'field_checkbox_options' => null,
                'is_required' => 1,
                'order' => 3,
                'hint' => 'contoh: 2 tahun 3 bulan',
            ],
            [
                'field_name' => 'penghasilan_perbulan',
                'field_label' => 'Penghasilan Perbulan',
                'field_type' => 'number',
                'field_options' => null,
                'field_checkbox_options' => null,
                'is_required' => 1,
                'order' => 4,
                'hint' => 'Hanya angka, contoh: 1000000',
            ],
        ];

        $suratKeteranganUsaha->formFields()->createMany($fields_suratKeteranganUsaha);
    }
}
