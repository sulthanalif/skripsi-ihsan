<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengantar Nikah</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            line-height: 1.2;
        }
        .container {
            width: 80%;
            margin: 0 auto;
        }
        .kop-surat {
            text-align: center;
            border-bottom: 4px double black;
            padding-bottom: 10px;
            /* margin-bottom: 5px; */
        }
        .kop-surat .logo {
            float: left;
            width: 90px;
            height: auto;
            margin-right: 20px;
        }
        .kop-surat h1, .kop-surat h2, .kop-surat p {
            margin: 0;
        }
        .kop-surat h1 {
            font-size: 18px;
            font-weight: bold;
        }
        .kop-surat h2 {
            font-size: 20px;
            font-weight: bold;
        }
        .kop-surat p {
            font-size: 12px;
        }
        .title, .number {
            text-align: center;
        }
        .title {
            font-size: 1.2em;
            font-weight: bold;
            text-decoration: underline;
        }
        .number {
            margin-top: -30px;
        }
        .content-table {
            margin-top: -15px;
            margin-bottom: -10px;
        }
        .content-table td {
            padding-left: 5px;
            vertical-align: top;
        }
        .signature {
            width: 30%;
            float: right;
            text-align: center;
            /* margin-top: 5px; */
        }
        .clear {
            clear: both;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="kop-surat">
            <img src="logo-doc.png" alt="Logo Kabupaten" class="logo">
            <h1>PEMERINTAH KABUPATEN BANDUNG</h1>
            <h1>KECAMATAN CIPARAY</h1>
            <h2>KEPALA DESA BUMIWANGI</h2>
            <p>Jl. Raya Laswi No. 123, Desa Bumiwangi, Ciparay, Bandung 40381</p>
        </div>

        <div class="title">
            <p>PENGANTAR NIKAH</p>
        </div>
        <div class="number">
            <p>Nomor : {{ $no_urut }}</p>
        </div>

        <p>Yang bertandatangan di bawah ini menjelaskan dengan sesungguhnya bahwa:</p>

        <table class="content-table">
            <tr>
                <td style="width: 35%;">1. Nama</td>
                <td style="width: 5%;">:</td>
                <td>{{ $user['name'] }}</td>
            </tr>
            <tr>
                <td>2. Nomor Induk Kependudukan (NIK)</td>
                <td>:</td>
                <td>{{ $user['profile']['nik'] }}</td>
            </tr>
            <tr>
                <td>3. Jenis Kelamin</td>
                <td>:</td>
                <td>{{ $user['profile']['gender'] }}</td>
            </tr>
            <tr>
                <td>4. Tempat dan tanggal lahir</td>
                <td>:</td>
                <td>{{ $user['profile']['birth_place'] }}, {{ date('d-m-Y', strtotime($user['profile']['birth_date'])) }}</td>
            </tr>
            <tr>
                <td>5. Kewarganegaraan</td>
                <td>:</td>
                <td>{{ $user['profile']['nationality'] }}</td>
            </tr>
            <tr>
                <td>6. Agama</td>
                <td>:</td>
                <td>{{ $user['profile']['religion'] }}</td>
            </tr>
            <tr>
                <td>7. Pekerjaan</td>
                <td>:</td>
                <td>{{ $user['profile']['occupation'] }}</td>
            </tr>
            <tr>
                <td>8. Alamat</td>
                <td>:</td>
                <td>{{ $user['profile']['address_ktp'] }}</td>
            </tr>
            <tr>
                <td>9. Status Perkawinan</td>
                <td>:</td>
                <td>
                    {{ $fields['status_pernikahan'] }}
                </td>
            </tr>
            <tr>
                <td>10. Nama istri/suami terdahulu</td>
                <td>:</td>
                <td>{{ $fields['nama_istri_suami_terdahulu'] }}</td>
            </tr>
        </table>

        <p class="section-heading">Adalah benar anak dari perkawinan seorang pria:</p>
        <table class="content-table">
            <tr>
                <td style="width: 35%;">Nama Lengkap dan alias</td>
                <td style="width: 5%;">:</td>
                <td>{{ $fields['nama_lengkap_dan_alias_ayah'] }}</td>
            </tr>
             <tr>
                <td>Nomor Induk Kependudukan (NIK)</td>
                <td>:</td>
                <td>{{ $fields['nik_ayah'] }}</td>
            </tr>
             <tr>
                <td>Tempat dan tanggal lahir</td>
                <td>:</td>
                <td>{{ $fields['tempat_lahir_ayah'] }}, {{ $fields['tanggal_lahir_ayah'] }}</td>
            </tr>
             <tr>
                <td>Kewarganegaraan</td>
                <td>:</td>
                <td>{{ $fields['kewarganegaraan_ayah'] }}</td>
            </tr>
             <tr>
                <td>Agama</td>
                <td>:</td>
                <td>{{ $fields['agama_ayah'] }}</td>
            </tr>
             <tr>
                <td>Pekerjaan</td>
                <td>:</td>
                <td>{{ $fields['pekerjaan_ayah'] }}</td>
            </tr>
             <tr>
                <td>Alamat</td>
                <td>:</td>
                <td>{{ $fields['alamat_ayah'] }}</td>
            </tr>
        </table>

        <p class="section-heading">Dengan seorang wanita:</p>
         <table class="content-table">
            <tr>
                <td style="width: 35%;">Nama Lengkap dan alias</td>
                <td style="width: 5%;">:</td>
                <td>{{ $fields['nama_lengkap_dan_alias_ibu'] }}</td>
            </tr>
             <tr>
                <td>Nomor Induk Kependudukan (NIK)</td>
                <td>:</td>
                <td>{{ $fields['nik_ibu'] }}</td>
            </tr>
             <tr>
                <td>Tempat dan tanggal lahir</td>
                <td>:</td>
                <td>{{ $fields['tempat_lahir_ibu'] }}, {{ $fields['tanggal_lahir_ibu'] }}</td>
            </tr>
             <tr>
                <td>Kewarganegaraan</td>
                <td>:</td>
                <td>{{ $fields['kewarganegaraan_ibu'] }}</td>
            </tr>
             <tr>
                <td>Agama</td>
                <td>:</td>
                <td>{{ $fields['agama_ibu'] }}</td>
            </tr>
             <tr>
                <td>Pekerjaan</td>
                <td>:</td>
                <td>{{ $fields['pekerjaan_ibu'] }}</td>
            </tr>
             <tr>
                <td>Alamat</td>
                <td>:</td>
                <td>{{ $fields['alamat_ibu'] }}</td>
            </tr>
        </table>

        <p>Demikian, surat pengantar ini dibuat dengan mengingat sumpah jabatan dan untuk dipergunakan sebagaimana mestinya.</p>

        <div class="signature">
            <p>Bumiwangi, {{ $created_at }}</p>
            <p>{{ $role_user_sign == 'Kepala Desa' ? '' : 'An' }} KEPALA DESA BUMIWANGI</p>
            <p>{{ $role_user_sign == 'Kepala Desa' ? '' : $role_user_sign }}</p>

            @if($sign_image)
            <div>
                <img  src="data:image/png;base64,{{ $sign_image }}" style="width: 100px" />
            </div>
            @endif

            <p><strong>{{ $user_sign ? $user_sign['name'] : '' }}</strong></p>
        </div>
        <div class="clear"></div>
    </div>
</body>
</html>
