<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Keterangan Tidak Mampu</title>
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
            margin-bottom: 20px;
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
            margin-top: 10px;
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
            <p>SURAT KETERANGAN TIDAK MAMPU</p>
        </div>
        <div class="number">
            <p>Nomor : {{ $no_urut }}</p>
        </div>

        <p>Yang bertanda tangan di bawah ini kepala Desa Bumiwangi kecamatan Ciparay Kabupaten Bandung, dengan ini menerangkan bahwa :</p>

        <table class="content-table">
            <tr>
                <td style="width: 30%;">N a m a</td>
                <td style="width: 5%;">:</td>
                <td>{{ $user['name'] }}</td>
            </tr>
            <tr>
                <td>Tempat tgl.lahir</td>
                <td>:</td>
                <td>{{ $user['profile']['birth_place'] }}, {{ date('d-m-Y', strtotime($user['profile']['birth_date'])) }}</td>
            </tr>
            <tr>
                <td>NIK</td>
                <td>:</td>
                <td>{{ $user['profile']['nik'] }}</td>
            </tr>
            <tr>
                <td>Jenis Kelamin</td>
                <td>:</td>
                <td>{{ $user['profile']['gender'] }}</td>
            </tr>
            <tr>
                <td>Agama</td>
                <td>:</td>
                <td>{{ $user['profile']['religion'] }}</td>
            </tr>
            <tr>
                <td>Status Perkawinan</td>
                <td>:</td>
                <td>{{ $user['profile']['marital_status'] }}</td>
            </tr>
            <tr>
                <td>Pekerjaan</td>
                <td>:</td>
                <td>{{ $user['profile']['occupation'] }}</td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td>:</td>
                <td>{{ $user['profile']['address_ktp'] }}</td>
            </tr>
        </table>

        <p>Adalah tanggungan dari :</p>

        <table class="content-table">
            <tr>
                <td style="width: 30%;">N a m a</td>
                <td style="width: 5%;">:</td>
                <td>{{ $fields['nama_penanggung'] }}</td>
            </tr>
            <tr>
                <td>Tempat tgl.lahir</td>
                <td>:</td>
                <td>{{ $fields['tempat_lahir_penanggung'] }}, {{ $fields['tanggal_lahir_penanggung'] }}</td>
            </tr>
            <tr>
                <td>NIK</td>
                <td>:</td>
                <td>{{ $fields['nik_penanggung'] }}</td>
            </tr>
            <tr>
                <td>Jenis Kelamin</td>
                <td>:</td>
                <td>{{ $fields['jenis_kelamin_penanggung'] }}</td>
            </tr>
            <tr>
                <td>Agama</td>
                <td>:</td>
                <td>{{ $fields['agama_penanggung'] }}</td>
            </tr>
            <tr>
                <td>Status Perkawinan</td>
                <td>:</td>
                <td>{{ $fields['status_perkawinan_penanggung'] }}</td>
            </tr>
            <tr>
                <td>Pekerjaan</td>
                <td>:</td>
                <td>{{ $fields['pekerjaan_penanggung'] }}</td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td>:</td>
                <td>{{ $fields['alamat_penanggung'] }}</td>
            </tr>
        </table>

        <p>Surat keterangan ini dipergunakan untuk:</p>
        <p align="center" style="font-weight: bold; font-style: italic;">Melengkapi persyaratan Administrasi Ke Rumah Sakit.</p>
        <p>Demikian, surat keterangan ini kami buat dengan sebenarnya agar yang berkepentingan menjadi tahu adanya dan dipergunakan sebagaimana mestinya.</p>

        <div class="signature">
            <p>Bumiwangi, {{ $created_at }}</p>
            <p>{{ $role_user_sign == 'kepala-desa' ? '' : 'An' }} KEPALA DESA BUMIWANGI</p>
            <p>{{ $role_user_sign == 'kelapa-desa' ? '' : $role_user_sign }}</p>

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
