<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    {{-- Judul dinamis berdasarkan variabel yang dikirim dari controller --}}
    <title>Laporan Bulanan - {{ $monthName }} {{ $year }}</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        .container {
            max-width: 800px;
            margin: auto;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .header p {
            margin: 5px 0 0;
            font-size: 16px;
            color: #555;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        thead th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        tfoot td {
            font-weight: bold;
            font-size: 1.1em;
            background-color: #f2f2f2;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Laporan Pengajuan Surat</h1>
            {{-- Periode dinamis --}}
            <p>Periode: Bulan {{ $monthName }} {{ $year }}</p>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Jenis Surat</th>
                    <th class="text-right">Jumlah Pengajuan</th>
                </tr>
            </thead>
            <tbody>
                {{--
                  Looping data dari collection $datas.
                  @forelse digunakan untuk menangani jika collection kosong.
                --}}
                @forelse($datas as $data)
                    <tr>
                        {{-- Mengambil nama dari relasi documentType --}}
                        <td>{{ $data->documentType->name }}</td>
                        {{-- Mengambil total dari properti total --}}
                        <td class="text-right">{{ $data->total }}</td>
                    </tr>
                @empty
                    {{-- Tampilan jika tidak ada data sama sekali --}}
                    <tr>
                        <td colspan="2" class="text-center">Tidak ada data untuk periode ini.</td>
                    </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr>
                    {{-- Total pengajuan dinamis --}}
                    <td>Total Pengajuan Bulan {{ $monthName }}</td>
                    {{-- Menjumlahkan semua nilai 'total' dari collection $datas --}}
                    <td class="text-right">{{ $datas->sum('total') }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
</body>
</html>
