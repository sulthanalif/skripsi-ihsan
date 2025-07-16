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

        $suratKeteranganTidakMampuRumahSakit = $documentType->create([
            'name' => 'Surat Keterangan Tidak Mampu (Rumah Sakit)',
            'number' => '400.7.3.6',
            'description' => 'Diperuntukan untuk keterangan tidak mampu',
            'status' => true,
        ]);

        $suratKeteranganTidakMampuKuliah = $documentType->create([
            'name' => 'Surat Keterangan Tidak Mampu (Kuliah)',
            'number' => '400.3.3',
            'description' => 'Diperuntukan untuk keterangan tidak mampu',
            'status' => true,
        ]);

        $suratPengantarNikah = $documentType->create([
            'name' => 'Surat Pengantar Nikah',
            'number' => '400.6',
            'description' => 'Diperuntukan untuk pengantar nikah',
            'status' => true,
        ]);

        $fields_suratPengantarNikah = [
            [
                'field_name' => 'status_pernikahan',
                'field_label' => 'Status Pernikahan',
                'field_type' => 'select',
                'field_options' => 'Jejaka, Duda, Beristri Ke.., Perawan, Janda',
                'field_checkbox_options' => null,
                'is_required' => 1,
                'order' => 1,
                'hint' => null,
            ],
            [
                'field_name' => 'beristri_ke',
                'field_label' => 'Beristri ke...',
                'field_type' => 'number',
                'field_options' => null,
                'field_checkbox_options' => null,
                'is_required' => 0,
                'order' => 2,
                'hint' => 'Isi jika memilih Beristri ke ..',
            ],
            [
                'field_name' => 'nama_istri_suami_terdahulu',
                'field_label' => 'Nama Istri/Suami Terdahulu',
                'field_type' => 'text',
                'field_options' => null,
                'field_checkbox_options' => null,
                'is_required' => 0,
                'order' => 3,
                'hint' => 'Isi jika ada..',
            ],
            [
                'field_name' => 'nama_lengkap_dan_alias_ayah',
                'field_label' => 'Nama Lengkap dan Alias Ayah',
                'field_type' => 'text', 
                'field_options' => null,
                'field_checkbox_options' => null,
                'is_required' => 1,
                'order' => 4,
                'hint' => null,
            ],
            [
                'field_name' => 'nik_ayah',
                'field_label' => 'NIK Ayah',
                'field_type' => 'number',
                'field_options' => null,
                'field_checkbox_options' => null,
                'is_required' => 1,
                'order' => 5,
                'hint' => 'Masukkan 16 digit NIK',
            ],
            [
                'field_name' => 'tempat_lahir_ayah',
                'field_label' => 'Tempat Lahir Ayah',
                'field_type' => 'text',
                'field_options' => null,
                'field_checkbox_options' => null,
                'is_required' => 1,
                'order' => 6,
                'hint' => null,
            ],
            [
                'field_name' => 'tanggal_lahir_ayah',
                'field_label' => 'Tanggal Lahir Ayah',
                'field_type' => 'date',
                'field_options' => null,
                'field_checkbox_options' => null,
                'is_required' => 1,
                'order' => 7,
                'hint' => null,
            ],
            [
                'field_name' => 'kewarganegaraan_ayah',
                'field_label' => 'Kewarganegaraan Ayah',
                'field_type' => 'text',
                'field_options' => null,
                'field_checkbox_options' => null,
                'is_required' => 1,
                'order' => 8,
                'hint' => null,
            ],
            [
                'field_name' => 'agama_ayah',
                'field_label' => 'Agama Ayah',
                'field_type' => 'select',
                'field_options' => 'Islam, Kristen, Katolik, Hindu, Buddha, Konghucu',
                'field_checkbox_options' => null,
                'is_required' => 1,
                'order' => 9,
                'hint' => null,
            ],
            [
                'field_name' => 'pekerjaan_ayah',
                'field_label' => 'Pekerjaan Ayah',
                'field_type' => 'text',
                'field_options' => null,
                'field_checkbox_options' => null,
                'is_required' => 1,
                'order' => 10,
                'hint' => null,
            ],
            [
                'field_name' => 'alamat_ayah',
                'field_label' => 'Alamat Ayah',
                'field_type' => 'textarea',
                'field_options' => null,
                'field_checkbox_options' => null,
                'is_required' => 1,
                'order' => 11,
                'hint' => null,
            ],
            [
                'field_name' => 'nama_lengkap_dan_alias_ibu',
                'field_label' => 'Nama Lengkap dan Alias Ibu',
                'field_type' => 'text',
                'field_options' => null,
                'field_checkbox_options' => null,
                'is_required' => 1,
                'order' => 12,
                'hint' => null,
            ],
            [
                'field_name' => 'nik_ibu',
                'field_label' => 'NIK Ibu',
                'field_type' => 'number',
                'field_options' => null,
                'field_checkbox_options' => null,
                'is_required' => 1,
                'order' => 13,
                'hint' => 'Masukkan 16 digit NIK',
            ],
            [
                'field_name' => 'tempat_lahir_ibu',
                'field_label' => 'Tempat Lahir Ibu',
                'field_type' => 'text',
                'field_options' => null,
                'field_checkbox_options' => null,
                'is_required' => 1,
                'order' => 14,
                'hint' => null,
            ],
            [
                'field_name' => 'tanggal_lahir_ibu',
                'field_label' => 'Tanggal Lahir Ibu',
                'field_type' => 'date',
                'field_options' => null,
                'field_checkbox_options' => null,
                'is_required' => 1,
                'order' => 15,
                'hint' => null,
            ],
            [
                'field_name' => 'kewarganegaraan_ibu',
                'field_label' => 'Kewarganegaraan Ibu',
                'field_type' => 'text',
                'field_options' => null,
                'field_checkbox_options' => null,
                'is_required' => 1,
                'order' => 16,
                'hint' => null,
            ],
            [
                'field_name' => 'agama_ibu',
                'field_label' => 'Agama Ibu',
                'field_type' => 'select',
                'field_options' => 'Islam, Kristen, Katolik, Hindu, Buddha, Konghucu',
                'field_checkbox_options' => null,
                'is_required' => 1,
                'order' => 17,
                'hint' => null,
            ],
            [
                'field_name' => 'pekerjaan_ibu',
                'field_label' => 'Pekerjaan Ibu',
                'field_type' => 'text',
                'field_options' => null,
                'field_checkbox_options' => null,
                'is_required' => 1,
                'order' => 18,
                'hint' => null,
            ],
            [
                'field_name' => 'alamat_ibu',
                'field_label' => 'Alamat Ibu',
                'field_type' => 'textarea',
                'field_options' => null,
                'field_checkbox_options' => null,
                'is_required' => 1,
                'order' => 19,
                'hint' => null,
            ]
        ];

        $fields_suratKeteranganTidakMampuRumahSakit = [
            [
                'field_name' => 'nama_penanggung',
                'field_label' => 'Nama Penanggung',
                'field_type' => 'text',
                'field_options' => null,
                'field_checkbox_options' => null,
                'is_required' => 1,
                'order' => 1,
                'hint' => null,
            ],
            [
                'field_name' => 'tempat_lahir_penanggung',
                'field_label' => 'Tempat Lahir Penanggung',
                'field_type' => 'text',
                'field_options' => null,
                'field_checkbox_options' => null,
                'is_required' => 1,
                'order' => 2,
                'hint' => null,
            ],
            [
                'field_name' => 'tanggal_lahir_penanggung',
                'field_label' => 'Tanggal Lahir Penanggung',
                'field_type' => 'date',
                'field_options' => null,
                'field_checkbox_options' => null,
                'is_required' => 1,
                'order' => 3,
                'hint' => null,
            ],
            [
                'field_name' => 'nik_penanggung',
                'field_label' => 'NIK Penanggung',
                'field_type' => 'number',
                'field_options' => null,
                'field_checkbox_options' => null,
                'is_required' => 1,
                'order' => 4,
                'hint' => 'Masukkan 16 digit NIK',
            ],
            [
                'field_name' => 'jenis_kelamin_penanggung',
                'field_label' => 'Jenis Kelamin Penanggung',
                'field_type' => 'select',
                'field_options' => 'Laki-laki, Perempuan',
                'field_checkbox_options' => null,
                'is_required' => 1,
                'order' => 5,
                'hint' => null,
            ],
            [
                'field_name' => 'agama_penanggung',
                'field_label' => 'Agama Penanggung',
                'field_type' => 'select',
                'field_options' => 'Islam, Kristen, Katolik, Hindu, Buddha, Konghucu',
                'field_checkbox_options' => null,
                'is_required' => 1,
                'order' => 6,
                'hint' => null,
            ],
            [
                'field_name' => 'status_perkawinan_penanggung',
                'field_label' => 'Status Perkawinan Penanggung',
                'field_type' => 'select',
                'field_options' => 'Belum Kawin, Kawin, Cerai Hidup, Cerai Mati',
                'field_checkbox_options' => null,
                'is_required' => 1,
                'order' => 7,
                'hint' => null,
            ],
            [
                'field_name' => 'pekerjaan_penanggung',
                'field_label' => 'Pekerjaan Penanggung',
                'field_type' => 'text',
                'field_options' => null,
                'field_checkbox_options' => null,
                'is_required' => 1,
                'order' => 8,
                'hint' => null,
            ],
            [
                'field_name' => 'alamat_penanggung',
                'field_label' => 'Alamat Penanggung',
                'field_type' => 'textarea',
                'field_options' => null,
                'field_checkbox_options' => null,
                'is_required' => 1,
                'order' => 9,
                'hint' => null,
            ]
        ];

        $fields_suratKeteranganTidakMampuKuliah = [
            [
                'field_name' => 'nama_penanggung',
                'field_label' => 'Nama Penanggung',
                'field_type' => 'text',
                'field_options' => null,
                'field_checkbox_options' => null,
                'is_required' => 1,
                'order' => 1,
                'hint' => null,
            ],
            [
                'field_name' => 'tempat_lahir_penanggung',
                'field_label' => 'Tempat Lahir Penanggung',
                'field_type' => 'text',
                'field_options' => null,
                'field_checkbox_options' => null,
                'is_required' => 1,
                'order' => 2,
                'hint' => null,
            ],
            [
                'field_name' => 'tanggal_lahir_penanggung',
                'field_label' => 'Tanggal Lahir Penanggung',
                'field_type' => 'date',
                'field_options' => null,
                'field_checkbox_options' => null,
                'is_required' => 1,
                'order' => 3,
                'hint' => null,
            ],
            [
                'field_name' => 'nik_penanggung',
                'field_label' => 'NIK Penanggung',
                'field_type' => 'number',
                'field_options' => null,
                'field_checkbox_options' => null,
                'is_required' => 1,
                'order' => 4,
                'hint' => 'Masukkan 16 digit NIK',
            ],
            [
                'field_name' => 'jenis_kelamin_penanggung',
                'field_label' => 'Jenis Kelamin Penanggung',
                'field_type' => 'select',
                'field_options' => 'Laki-laki, Perempuan',
                'field_checkbox_options' => null,
                'is_required' => 1,
                'order' => 5,
                'hint' => null,
            ],
            [
                'field_name' => 'agama_penanggung',
                'field_label' => 'Agama Penanggung',
                'field_type' => 'select',
                'field_options' => 'Islam, Kristen, Katolik, Hindu, Buddha, Konghucu',
                'field_checkbox_options' => null,
                'is_required' => 1,
                'order' => 6,
                'hint' => null,
            ],
            [
                'field_name' => 'status_perkawinan_penanggung',
                'field_label' => 'Status Perkawinan Penanggung',
                'field_type' => 'select',
                'field_options' => 'Belum Kawin, Kawin, Cerai Hidup, Cerai Mati',
                'field_checkbox_options' => null,
                'is_required' => 1,
                'order' => 7,
                'hint' => null,
            ],
            [
                'field_name' => 'pekerjaan_penanggung',
                'field_label' => 'Pekerjaan Penanggung',
                'field_type' => 'text',
                'field_options' => null,
                'field_checkbox_options' => null,
                'is_required' => 1,
                'order' => 8,
                'hint' => null,
            ],
            [
                'field_name' => 'alamat_penanggung',
                'field_label' => 'Alamat Penanggung',
                'field_type' => 'textarea',
                'field_options' => null,
                'field_checkbox_options' => null,
                'is_required' => 1,
                'order' => 9,
                'hint' => null,
            ],
            [
                'field_name' => 'pengantar_dari',
                'field_label' => 'Pengantar Dari',
                'field_type' => 'text',
                'field_options' => null,
                'field_checkbox_options' => null,
                'is_required' => 1,
                'order' => 10,
                'hint' => 'contoh: RT.03 RW.12',
            ],
        ];

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
        $suratKeteranganTidakMampuRumahSakit->formFields()->createMany($fields_suratKeteranganTidakMampuRumahSakit);
        $suratKeteranganTidakMampuKuliah->formFields()->createMany($fields_suratKeteranganTidakMampuKuliah);
        $suratPengantarNikah->formFields()->createMany($fields_suratPengantarNikah);
    }
}
