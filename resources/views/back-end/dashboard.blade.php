@extends('layouts.main')
@section('title', 'Dahsboard')
@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Dashboard</h1>
            </div>

        </div>
    </div><!-- /.container-fluid -->
</section>
 <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
        <div class="row">
            @foreach($stats as $stat)
            <div class="col-4 {{ $stat['hidden'] ?? '' }}">
                <div class="info-box">
                    <span class="info-box-icon {{ $stat['color'] }}"><i class="fas {{ $stat['icon'] }}"></i></span>
                    <div class="info-box-content">
                      <span class="info-box-text">{{ $stat['title'] }}</span>
                      <span class="info-box-number">{{ $stat['value'] }}</span>
                    </div>
                  </div>
                </div>
            @endforeach
        </div>
     @if (auth()->user()->roles->first()->name != 'warga' )
         <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Approval Dokument</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              @if($approvalDocuments->isEmpty())
                <p>Belum ada approval dokument apapun.</p>
              @else
                <div class="table-responsive">
                  <table id="data-table" class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nomer Urut</th>
                        {{-- <th>Judul Dokumen</th> --}}
                        <th>Tipe Dokumen</th>
                        <th>Dibuat Oleh</th>
                        <th>Status Approval</th>
                        <th>Tanggal Dibuat</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($approvalDocuments as $document)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $document->number }}</td>
                        {{-- <td>{{ $document->title }}</td> --}}
                        <td>{{ $document->documentType->name ?? 'N/A' }}</td>
                        <td>{{ $document->creator->name }}</td>
                        <td>
                            @if ($document->getLastUserApproval()->status == 'approved')
                                <span class="badge badge-success">Approved</span>
                            @elseif($document->getLastUserApproval()->status == 'rejected')
                                <span class="badge badge-danger">Rejected</span>
                            @else
                                <span class="badge badge-warning">Pending</span>
                            @endif
                        </td>
                        <td>{{ $document->created_at->format('d M Y, H:i') }}</td>
                        <td class="text-center" style="white-space:nowrap">
                            <a href="{{ route('document.generated.download', $document->id) }}" class="btn btn-sm btn-info" target="_blank">Lihat</a>
                             @if (!$document->approvalExists())
                                    @if ($document->user->id == auth()->user()->id || $document->creator->id == auth()->user()->id)
                                        <a href="{{ route('document.generated.edit', ['document_type' => $document->documentType->id, 'document' => $document->id]) }}" class="btn btn-sm btn-warning">Edit</a>
                                    @endif
                                @endif
                            <a href="{{ route('document.approval.index', $document->id) }}" class="btn btn-sm btn-success">Cek Status</a>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                  </table>
                </div>
              @endif
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
     @endif
      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>

  <!-- /.content -->
@endsection
