@extends('layouts.main')
@section('title', 'Document')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Laporan</h1>
            </div>

        </div>
    </div><!-- /.container-fluid -->
</section>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-end">
                        {{-- <div class="row">
                            <div class="col-md-6">
                                <select id="document_type_filter" class="form-control" data-selectjs="true">
                                    <option value="">Semua Tipe Dokumen</option>
                                    @foreach($types as $type)
                                        <option value="{{ $type->name }}">{{ $type->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <select id="status_filter" class="form-control" data-selectjs="true">
                                    <option value="">Semua Status Approval</option>
                                    <option value="approved">Approved</option>
                                    <option value="rejected">Rejected</option>
                                    <option value="pending">Pending</option>
                                </select>
                            </div>
                        </div> --}}
                        <div class="row">
                            <button id="btn-export" class="btn btn-success" data-toggle="modal" data-target="#modal-export">Export</button>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="table-responsive text-sm">
                      <table id="data-table-report" class="table table-bordered table-hover">
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
                        @foreach($documents as $document)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $document->number }}</td>
                            <td>{{ $document->documentType->name ?? 'N/A' }}</td>
                            <td>{{ $document->user->name }}</td>
                            <td>{{ $document->creator->name }}</td>
                            <td>
                                @if ($document->approval?->status == 'approved')
                                    <span class="badge badge-success">Approved</span>
                                @elseif($document->approval?->status == 'rejected')
                                    <span class="badge badge-danger">Rejected</span>
                                @else
                                    <span class="badge badge-warning">Pending</span>
                                @endif
                            </td>
                            <td>
                                @if ($document->approvalExists())
                                    {{ $document->approval->signBy->name  ?? '-'}}
                                @else
                                    -
                                @endif
                            </td>
                            <td>{{ $document->created_at->format('d M Y, H:i') }}</td>
                        </tr>
                        @endforeach
                        </tbody>
                      </table>
                    </div>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
            </div>
            <!-- /.col -->
          </div>
    </div>
</section>

@include('back-end.report.modal-export')
@endsection

@push('scripts')
<script>
    $(document).ready(function() {

        $("#data-table-report").DataTable({
        "responsive": true, // Membuat tabel responsif untuk berbagai ukuran layar
        "lengthChange": true, // Menampilkan dropdown "Show X entries"
        "autoWidth": false, // Menonaktifkan penyesuaian lebar kolom otomatis
        // "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"], // Mengaktifkan tombol ekspor/visibilitas kolom
        "paging": true, // Mengaktifkan pagination
        "ordering": true, // Mengaktifkan sorting kolom
        "info": true, // Menampilkan info jumlah entri
        "searching": true, // Mengaktifkan kolom pencarian
        // "dom": '<"row"<"col-sm-12 col-md-6"B><"col-sm-12 col-md-6"f>>' +
        //        '<"row"<"col-sm-12"tr>>' +
        //        '<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>', // Custom DOM for better responsive layout
        "language": { // Opsi: Ubah teks menjadi Bahasa Indonesia
              "lengthMenu": "Tampilkan _MENU_ entri per halaman",
              "zeroRecords": "Tidak ada data yang ditemukan",
              "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
              "infoEmpty": "Tidak ada entri",
              "infoFiltered": "(difilter dari _MAX_ total entri)",
              "search": "Cari:",
              "paginate": {
                  "first": "Awal",
                  "last": "Akhir",
                  "next": "Berikutnya",
                  "previous": "Sebelumnya"
              },
              "aria": {
                  "sortAscending": ": aktifkan untuk mengurutkan kolom secara naik",
                  "sortDescending": ": aktifkan untuk mengurutkan kolom secara menurun"
              }
          }
      });
    });
</script>
@endpush
