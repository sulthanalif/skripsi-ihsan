<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Dokumen</title>
    <style>
        /* Gaya dasar untuk keseluruhan dokumen */
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            margin: 20px;
            font-size: 12px; /* Ukuran font dikecilkan */
            color: #333;
        }

        /* Gaya utama untuk tabel */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            table-layout: fixed; /* Mengatur layout tabel menjadi fixed */
        }

        /* Gaya untuk header tabel (thead) */
        thead th {
            background-color: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
            padding: 8px 5px; /* Padding dikurangi */
            text-align: left;
            font-weight: 600;
            color: #495057;
            font-size: 11px; /* Ukuran font header lebih kecil */
            word-wrap: break-word; /* Memungkinkan text wrapping */
        }

        /* Gaya untuk sel data (td) */
        tbody td {
            border-bottom: 1px solid #dee2e6;
            padding: 8px 5px; /* Padding dikurangi */
            word-wrap: break-word; /* Memungkinkan text wrapping */
            font-size: 10px; /* Ukuran font content lebih kecil */
        }

        /* Mengatur lebar kolom spesifik */
        th:nth-child(1), td:nth-child(1) { width: 5%; } /* No. */
        th:nth-child(2), td:nth-child(2) { width: 10%; } /* Nomer Urut */
        th:nth-child(3), td:nth-child(3) { width: 15%; } /* Tipe Dokumen */
        th:nth-child(4), td:nth-child(4) { width: 15%; } /* Atas Nama */
        th:nth-child(5), td:nth-child(5) { width: 15%; } /* Dibuat Oleh */
        th:nth-child(6), td:nth-child(6) { width: 10%; } /* Status Approval */
        th:nth-child(7), td:nth-child(7) { width: 15%; } /* Ditandatangani Oleh */
        th:nth-child(8), td:nth-child(8) { width: 15%; } /* Tanggal Dibuat */

        /* Zebra-striping untuk baris ganjil di body tabel */
        tbody tr:nth-child(odd) {
            background-color: #fdfdfd;
        }

        /* Gaya untuk badge status */
        .status {
            padding: 3px 6px; /* Padding dikurangi */
            border-radius: 12px;
            font-size: 10px; /* Ukuran font badge dikecilkan */
            font-weight: 600;
            text-align: center;
            display: inline-block;
        }

        /* Gaya spesifik untuk status "Approved" */
        .status-approved {
            background-color: #d4edda;
            color: #155724;
        }

        /* Gaya spesifik untuk status "Pending" */
        .status-pending {
            background-color: #fff3cd;
            color: #856404;
        }

        h1 {
            font-size: 16px; /* Ukuran judul dikecilkan */
            margin-bottom: 15px;
        }
    </style>
</head>
<body>

    <h1>Daftar Pengajuan Dokumen</h1>

    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Nomer Urut</th>
                <th>Tipe Dokumen</th>
                <th>Atas Nama</th>
                <th>Dibuat Oleh</th>
                <th>Status Approval</th>
                <th>Ditandatangani Oleh</th>
                <th>Tanggal Dibuat</th>
            </tr>
        </thead>
        <tbody>
            @foreach($datas as $index => $data)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $data->number }}</td>
                <td>{{ $data->documentType->name ?? 'N/A' }}</td>
                <td>{{ $data->user->name }}</td>
                <td>{{ $data->creator->name }}</td>
                <td>
                    {{ $data->approval?->status ?? 'pending' }}
                </td>
                <td>
                    @if ($data->approvalExists())
                        {{ $data->approval->signBy->name ?? '-' }}
                    @else
                        -
                    @endif
                </td>
                <td>{{ $data->created_at->format('d M Y, H:i') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
