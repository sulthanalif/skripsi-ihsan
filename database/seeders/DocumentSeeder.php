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
            'number' => '400.8',
            'description' => 'Diperuntukan untuk keterangan domisili',
            'status' => true,
        ]);

        $suratKeteranganUsaha = $documentType->create([
            'name' => 'Surat Keterangan Usaha',
            'number' => '400.4',
            'description' => 'Diperuntukan untuk keterangan usaha',
            'status' => true,
        ]);

        $suratKeteranganTidakMampu = $documentType->create([
            'name' => 'Surat Keterangan Tidak Mampu (Rumah Sakit)',
            'number' => '400.7.3.6',
            'description' => 'Diperuntukan untuk keterangan tidak mampu',
            'status' => true,
        ]);

        $suratKeteranganTidakMampu = $documentType->create([
            'name' => 'Surat Keterangan Tidak Mampu (Sekolah)',
            'number' => '400.3.3',
            'description' => 'Diperuntukan untuk keterangan tidak mampu',
            'status' => true,
        ]);

        $fields_suratKeteranganDomisili = [
            [
                'field_name' => 'keterangan_dari',
                'field_label' => 'Keterangan Dari',
                'field_type' => 'text',
                'field_options' => null,
                'field_checkbox_options' => null,
                'is_required' => 1,
                'order' => 1,
                'hint' => null,
            ],
            [
                'field_name' => 'alamat_domisili',
                'field_label' => 'Alamat Domisili',
                'field_type' => 'textarea',
                'field_options' => null,
                'field_checkbox_options' => null,
                'is_required' => 1,
                'order' => 2,
                'hint' => null,
            ]
        ];


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


        $suratKeteranganDomisili->formFields()->createMany($fields_suratKeteranganDomisili);
        $suratKeteranganUsaha->formFields()->createMany($fields_suratKeteranganUsaha);
    }
}
