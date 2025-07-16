<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Keterangan Usaha</title>
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
            <p>SURAT KETERANGAN USAHA</p>
        </div>
        <div class="number">
            <p>Nomor : {{ $no_urut }}</p>
        </div>

        <p>Yang bertanda tangan di bawah ini kepala Desa Bumiwangi kecamatan Ciparay Kabupaten Bandung, dengan ini menerangkan :</p>

        <table class="content-table">
             <tr>
                <td style="width: 30%;">1. Nama Lengkap</td>
                <td style="width: 5%;">:</td>
                <td>{{ $user['name'] }}</td>
            </tr>
            <tr>
                <td>2. No NIK</td>
                <td>:</td>
                <td>{{ $user['profile']['nik'] }}</td>
            </tr>
            <tr>
                <td>3. Tempat,Tanggal,Lahir</td>
                <td>:</td>
                <td>{{ $user['profile']['birth_place'] }}, {{ date('d-m-Y', strtotime($user['profile']['birth_date'])) }}</td>
            </tr>
            <tr>
                <td>4. Jenis Kelamin</td>
                <td>:</td>
                <td>{{ $user['profile']['gender'] }}</td>
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
                <td>7. Status</td>
                <td>:</td>
                <td>{{ $user['profile']['marital_status'] }}</td>
            </tr>
            <tr>
                <td>8. Pekerjaan</td>
                <td>:</td>
                <td>{{ $user['profile']['occupation'] }}</td>
            </tr>
            <tr>
                <td>9. Alamat</td>
                <td>:</td>
                <td>{{ $user['profile']['address_ktp'] }}</td>
            </tr>
        </table>

        <p>Adalah benar yang bersangkutan diatas pada saat ini memiliki Perusahaan di Wilayah Desa Bumiwangi Kecamatan Ciparay Kabupaten Bandung yang bergerak dibidang :</p>

        <table class="content-table">
            <tr>
                <td style="width: 30%;">Jenis Usaha</td>
                <td style="width: 5%;">:</td>
                <td>{{ $fields['jenis_usaha'] }}</td>
            </tr>
            <tr>
                <td>Alamat Usaha</td>
                <td>:</td>
                <td>{{ $fields['alamat_usaha'] }}</td>
            </tr>
            <tr>
                <td>Lama Usaha</td>
                <td>:</td>
                <td>{{ $fields['lama_usaha'] }}</td>
            </tr>
            <tr>
                <td>Penghasilan Perbulan</td>
                <td>:</td>
                <td>Rp.{{ number_format($fields['penghasilan_perbulan'], 0, ',', '.') }}</td>
            </tr>
        </table>

        <p>Surat Keterangan di buat Untuk : </p>
          <p align="center" style="font-weight: bold; font-style: italic;"> Melengkapi Persyaratan Administrasi</p>
        <p>Demikian surat keterangan ini kami buat dengan sebenarnya,agar yang berkepentingan menjadi tahu dan dapat dipergunakan sebagaimana mestinya.</p>

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
