<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Tahunan - {{ $year }}</title>
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
        h1 { margin: 0; font-size: 24px; }
        .header p { margin: 5px 0 0; font-size: 16px; color: #555; }
        h2 {
            font-size: 18px;
            margin-top: 40px;
            margin-bottom: 15px;
            border-bottom: 2px solid #f2f2f2;
            padding-bottom: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
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
        .total-row td {
            font-weight: bold;
            font-size: 1.2em;
            background-color: #e9ecef;
            padding: 15px 12px;
        }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Laporan Pengajuan Surat</h1>
            <p>Periode: Tahun {{ $year }}</p>
        </div>

        <h2>Rekapitulasi Bulanan</h2>
        <table>
            <thead>
                <tr>
                    <th>Bulan</th>
                    <th class="text-right">Jumlah Pengajuan</th>
                </tr>
            </thead>
            <tbody>
                @php
                    // Array nama bulan untuk mapping dari angka bulan
                    $allMonths = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                @endphp
                {{-- Loop sebanyak 12 bulan untuk memastikan semua bulan tampil --}}
                @foreach ($allMonths as $index => $monthName)
                    @php
                        // Cari data untuk bulan saat ini (index + 1)
                        $dataForMonth = $monthlyData->firstWhere('month', $index + 1);
                        // Jika ada data, ambil totalnya, jika tidak, totalnya 0
                        $total = $dataForMonth ? $dataForMonth->total : 0;
                    @endphp
                    <tr>
                        <td>{{ $monthName }}</td>
                        <td class="text-right">{{ $total }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <h2>Rekapitulasi Berdasarkan Jenis Surat</h2>
        <table>
            <thead>
                <tr>
                    <th>Jenis Surat</th>
                    <th class="text-right">Jumlah Pengajuan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($byTypeData as $data)
                    <tr>
                        <td>{{ $data->documentType->name }}</td>
                        <td class="text-right">{{ $data->total }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2" class="text-center">Tidak ada data untuk periode ini.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <table>
             <tr class="total-row">
                <td>Total Pengajuan Tahun {{ $year }}</td>
                {{-- Hitung total dari data yang dikelompokkan per jenis surat --}}
                <td class="text-right">{{ $byTypeData->sum('total') }}</td>
            </tr>
        </table>
    </div>
</body>
</html>
