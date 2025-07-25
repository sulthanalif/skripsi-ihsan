@extends('layouts.main')
@section('title', 'Document')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Document</h1>
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
                    <div class="row">
                        <div class="col-md-3">
                            <select id="document_type_filter" class="form-control" data-selectjs="true">
                                <option value="">Semua Tipe Dokumen</option>
                                @foreach($types as $type)
                                    <option value="{{ $type->name }}">{{ $type->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select id="status_filter" class="form-control" data-selectjs="true">
                                <option value="">Semua Status Approval</option>
                                <option value="approved">Approved</option>
                                <option value="rejected">Rejected</option>
                                <option value="pending">Pending</option>
                            </select>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="table-responsive">
                      <table id="data-table" class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nomer Urut</th>
                            {{-- <th>Judul Dokumen</th> --}}
                            <th>Tipe Dokumen</th>
                            <th>Atas Nama</th>
                            <th>Dibuat Oleh</th>
                            <th>Status Approval</th>
                            <th>Ditandatangani Oleh</th>
                            <th>Tanggal Dibuat</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($documents as $document)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $document->number }}</td>
                            {{-- <td>{{ $document->title }}</td> --}}
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
                            <td class="text-center" style="white-space:nowrap">
                                @if (auth()->user()->roles->first()->name != 'warga' && $document->approval?->status == 'approved' && $document->approval?->generated_at)
                                <a href="{{ route('document.generated.download', $document->id) }}" class="btn btn-sm btn-info" target="_blank">Lihat</a>
                                @elseif(auth()->user()->roles->first()->name == 'warga' && $document->approvalExists() && $document->approval->sign)
                                <a href="{{ route('document.generated.download', $document->id) }}" class="btn btn-sm btn-info" target="_blank">Lihat</a>
                                @endif
                                {{-- @if (!$document->approvalExists())
                                    @if ($document->user->id == auth()->user()->id || $document->creator->id == auth()->user()->id)
                                        <a href="{{ route('document.generated.edit', ['document_type' => $document->documentType->id, 'document' => $document->id]) }}" class="btn btn-sm btn-warning">Edit</a>
                                    @endif
                                @endif --}}
                                <a href="{{ route('document.approval.index', $document->id) }}" class="btn btn-sm btn-success">Cek Status</a>
                            </td>
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
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        function filterTable() {
            var typeValue = $('#document_type_filter').val().toLowerCase();
            var statusValue = $('#status_filter').val().toLowerCase();

            $("#data-table tbody tr").each(function() {
                var row = $(this);
                var typeMatch = !typeValue || row.find("td:eq(2)").text().toLowerCase().indexOf(typeValue) > -1;
                var statusMatch = !statusValue || row.find("td:eq(5)").text().toLowerCase().indexOf(statusValue) > -1;
                row.toggle(typeMatch && statusMatch);
            });
        }

        $('#document_type_filter, #status_filter').on('change', filterTable);
    });
</script>
@endpush
