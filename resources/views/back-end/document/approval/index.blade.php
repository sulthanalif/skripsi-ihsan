@extends('layouts.main')
@section('title', 'Document Approval')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
               <div class="card">
                    <div class="p-3 d-flex justify-content-center w-full">
                        <table class="table table-borderless mb-0 text-md w-full">
                            <tr class="p-0">
                                <td style="width: 25%; padding: 4px">
                                    Type Document
                                </td>
                                <td style="width: 5%; padding: 4px">
                                    :
                                </td>
                                <td style="padding: 4px">
                                    {{ $document->documentType->name }}
                                </td>
                            </tr>
                            <tr class="p-0">
                                <td style="padding: 4px">
                                    Nomer Urut
                                </td>
                                <td style="padding: 4px">
                                    :
                                </td>
                                <td style="padding: 4px">
                                    {{ $document->number }}
                                </td>
                            </tr>
                            <tr class="p-0">
                                <td style="padding: 4px">
                                    Dibuat Oleh
                                </td>
                                <td style="padding: 4px">
                                    :
                                </td>
                                <td style="padding: 4px">
                                    {{ $document->creator->name }}
                                </td>
                            </tr>
                            <tr class="p-0">
                                <td style="padding: 4px">
                                    Atas Nama
                                </td>
                                <td style="padding: 4px">
                                    :
                                </td>
                                <td style="padding: 4px">
                                    {{ $document->user->name }}
                                </td>
                            </tr>
                        </table>
                        <table class="table table-borderless mb-0 text-md">
                            <tr class="p-0">
                                <td style="width: 30%; padding: 4px">
                                    Status Approval
                                </td>
                                <td style="width: 5%; padding: 4px">
                                    :
                                </td>
                                <td style="padding: 4px">
                                    {{ ucfirst($document->approval?->status ?? 'Pending') }}
                                </td>
                            </tr>
                            <tr class="p-0">
                                <td style="width: 20%; padding: 4px">
                                    Status Document Ditandatangani
                                </td>
                                <td style="width: 5%; padding: 4px">
                                    :
                                </td>
                                <td style="padding: 4px">
                                    {{ ucfirst($document->approval?->sign ? 'Telah Ditandatangani' : 'Belum Ditandatangani') }}
                                </td>
                            </tr>
                            <tr class="p-0">
                                <td style="width: 20%; padding: 4px">
                                    Input User
                                </td>
                                <td style="width: 5%; padding: 4px">
                                    :
                                </td>
                                <td style="padding: 4px">
                                    <a id="detail-input" class="btn btn-primary btn-sm" data-document="{{ json_encode($document->getFieldAndValues()) }}">Cek</a>
                                </td>
                            </tr>
                        </table>
                        <table class="table table-borderless mb-0 text-md">
                            <tr class="p-0">
                                <td style="width: 50%; padding: 4px">
                                    Surat Pengantar RT
                                </td>
                                <td style="width: 5%; padding: 4px">
                                    :
                                </td>
                                <td style="padding: 4px">
                                    @if($document->surat_pengantar_rt)
                                        <a class="btn btn-primary btn-sm" href="/storage/files/{{ $document->surat_pengantar_rt }}" target="_blank">Cek</a>
                                    @else
                                        Tidak ada
                                    @endif
                                </td>
                            </tr>
                            <tr class="p-0">
                                <td style="width: 20%; padding: 4px">
                                    Surat Pengantar RW
                                </td>
                                <td style="width: 5%; padding: 4px">
                                    :
                                </td>
                                <td style="padding: 4px">
                                    @if($document->surat_pengantar_rw)
                                        <a class="btn btn-primary btn-sm"  href="/storage/files/{{ $document->surat_pengantar_rw }}" target="_blank">Cek</a>
                                    @else
                                        Tidak ada
                                    @endif
                                </td>
                            </tr>
                            <tr class="p-0">
                                <td style="width: 20%; padding: 4px">
                                    Kartu Keluarga
                                </td>
                                <td style="width: 5%; padding: 4px">
                                    :
                                </td>
                                <td style="padding: 4px">
                                    @if($document->kk)
                                        <a class="btn btn-primary btn-sm" href="/storage/files/{{ $document->kk }}" target="_blank">Cek</a>
                                    @else
                                        Tidak ada
                                    @endif
                                </td>
                            </tr>
                            <tr class="p-0">
                                <td style="width: 20%; padding: 4px">
                                    Kartu Tanda Penduduk
                                </td>
                                <td style="width: 5%; padding: 4px">
                                    :
                                </td>
                                <td style="padding: 4px">
                                    @if($document->ktp)
                                        <a class="btn btn-primary btn-sm" href="/storage/files/{{ $document->ktp }}" target="_blank">Cek</a>
                                    @else
                                        Tidak ada
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
               </div>
            </div>
        </div>
    </div>
</section>
<section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="timeline w-100">
            <!-- Timeline time label -->
            <div class="time-label">
                <span class="bg-green btn mr-4">Tanggal Pengajuan: {{ \Carbon\Carbon::parse($document->created_at)->format('d M Y') }}</span>
                @if(auth()->user()->roles->first()->name != 'warga' && $document->approval?->status == 'approved' && $document->approval?->generated_at)
                <span class="btn btn-primary"><a href="{{ route('document.generated.download', $document->id) }}"target="_blank">Lihat Document</a></span>
                @elseif(auth()->user()->roles->first()->name == 'warga' && $document->approvalExists() && $document->approval->sign)
                <span class="btn btn-primary"><a href="{{ route('document.generated.download', $document->id) }}"target="_blank">Lihat Document</a></span>
                @endif


            </div>
            <div>
                <!-- Before each timeline item corresponds to one icon on the left scale -->
                <i class="fas fa-{{
                    !$document->approval ? 'clock bg-gray' :
                    ($document->approval->status === 'approved' ? 'check bg-green' :
                    ($document->approval->status === 'rejected' ? 'times bg-red' : 'clock bg-gray'))
                }}"></i>
                <!-- Timeline item -->
                <div class="timeline-item">
                    <!-- Time -->
                    @if($document->approval?->created_at)
                    <span class="time"><i class="fas fa-clock"></i> {{ \Carbon\Carbon::parse($document->created_at)->format('H:i, d M Y') }}</span>
                    @endif
                    <!-- Header. Optional -->
                    <h3 class="timeline-header"><a class="text-primary" >@if($document->approval?->status == 'approved') Disetujui @elseif($document->approval?->status == 'rejected') Ditolak @else Menunggu Persetujuan ... @endif</a></h3>
                    <!-- Body -->
                    <div class="timeline-body">
                        @if($document->approval?->status == 'approved')
                            <p>Telah Disetujui oleh {{ $document->approval?->user->name }}</p>
                        @elseif($document->approval?->status == 'rejected')
                            <p>Telah Ditolak oleh {{ $document->approval?->user->name }}</p>
                        @else
                        Menunggu Persetujuan ...
                        @endif

                        @if(Auth::user()->can('action-approve') && !$document->approvalExists())
                            <div class="d-flex justify-content-start py-3 mx-3">
                                <button class="btn btn-success mr-2" id='btn-approve' data-url="{{ route('document.approval.approve', $document) }}">Approve</button>
                                <button class="btn btn-danger" id='btn-reject' data-url="{{ route('document.approval.reject', $document) }}">Reject</button>
                            </div>
                        @endif


                        @if($document->approvalExists())
                            <b>Note : {{ $document->approval?->note ?? '-' }}</b>
                        @endif

                        @if(auth()->user()->roles->first()->name != 'warga' && $document->approval?->status == 'approved' && !$document->approval?->generated_at)
                        <div class="d-flex justify-content-start py-3 mx-2">
                            <a href="{{ route('document.approval.generate', $document) }}" class="btn btn-success mr-2">Buat Document</a>
                            {{-- <button class="btn btn-danger" id='btn-reject' data-url="{{ route('document.approval.reject', $document) }}">Reject</button> --}}
                        </div>
                        @endif
                    </div>
                </div>
                <!-- Body -->

            </div>
            <div>
                <!-- Before each timeline item corresponds to one icon on the left scale -->
                <i class="fas fa-{{ $document->approval?->sign ? 'check bg-green' : 'clock bg-gray' }}"></i>
                <!-- Timeline item -->
                <div class="timeline-item">
                    <!-- Time -->
                    @if($document->approval?->sign_at)
                    <span class="time"><i class="fas fa-clock"></i> {{ \Carbon\Carbon::parse($document->approval?->sign_at)->format('H:i, d M Y') }}</span>
                    @endif
                    <!-- Header. Optional -->
                    <h3 class="timeline-header"><a class="text-primary">{{ 'Sudah Ditandatangani' ?? 'Belum Ditandatangani' }}</a> </h3>

                    <!-- Body -->
                    <div class="timeline-body">
                        @if($document->approval?->sign) Telah Ditandatangani Oleh {{ $document->approval?->signBy->name }} @else Menunggu Tanda Tangan ... @endif
                    </div>

                    @if(Auth::user()->can('action-sign') && $document->approvalExists() && !$document->approval?->sign && $document->approval?->status == 'approved')
                        <div class="d-flex justify-content-start  py-3 mx-3">
                            <button class="btn btn-success mr-2" id='btn-sign' data-url="{{ route('document.approval.sign', $document) }}">Tandatangani</button>
                            {{-- <button class="btn btn-danger" id='btn-reject' data-url="{{ route('document.approval.reject', $document) }}">Reject</button> --}}
                        </div>
                    @endif
                    @if($document->approvalExists() && $document->approval?->sign)
                    <div>
                        <img  src="data:image/png;base64,{{ $document->approval?->qr_code_image }}" alt="qrcode{{ $document->approval?->sign }}" />
                    </div>
                    @endif
                    <!-- Placement of additional controls. Optional -->
                    </div>
                </div>
            {{-- <div>
              <i class="fas fa-clock bg-gray"></i>
            </div> --}}
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
<!-- Main node for this component -->
      <div class="d-flex justify-content-end mx-4">
        <a href="{{ route('document.index') }}" class="btn btn-secondary">Kembali</a>
      </div>

    </div><!-- /.container-fluid -->
</section>

<div class="modal fade" id="modal-action" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-md modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Apakah Anda Yakin?</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
            <form action="" method="POST" id="form-approve" class="form-horizontal" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="note" class="form-label">Note</label>
                                <textarea type="text" rows="5" name="note" class="form-control @error('note') is-invalid @enderror" id="note" placeholder="Maukan Note disini"></textarea>
                                @error('note')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button id="btn-submit" type="submit" type="submit" class="btn"></button>
                </div>
            </form>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="modal fade" id="modal-detail" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">User Input</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body" id="modal-detail-body">

        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

{{-- @include('back-end.document.approval.modal-closed') --}}
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#detail-input').on('click', function () {
                // Mengambil data dari atribut data-document
                var fieldValues = $(this).data('document');
                var modalBody = $('#modal-detail-body');
                modalBody.empty(); // Kosongkan konten modal sebelumnya

                // Buat elemen tabel
                var table = $('<table>').addClass('table table-bordered');
                var tbody = $('<tbody>');

                // Jika data masih dalam bentuk string JSON, ubah menjadi objek/array
                if (typeof fieldValues === 'string') {
                    try {
                        fieldValues = JSON.parse(fieldValues);
                    } catch (e) {
                        console.error('Gagal mem-parsing data JSON:', e);
                        // Tampilkan pesan error jika parsing gagal
                        tbody.append('<tr><td colspan="2" class="text-danger">Error: Format data tidak valid.</td></tr>');
                        table.append(tbody);
                        modalBody.append(table);
                        $('#modal-detail').modal('show');
                        return; // Hentikan eksekusi
                    }
                }

                // --- BAGIAN UTAMA YANG DIPERBAIKI ---
                // Cek apakah fieldValues adalah sebuah array dan memiliki isi
                if (Array.isArray(fieldValues) && fieldValues.length > 0) {
                    // Lakukan perulangan untuk setiap item (objek) di dalam array
                    fieldValues.forEach(function(item) {
                        var tr = $('<tr>');
                        // Kolom pertama diisi dengan 'field_label' dari setiap item
                        tr.append($('<td>').text(item.field_label));
                        // Kolom kedua diisi dengan 'value', tampilkan '-' jika kosong
                        tr.append($('<td>').text(item.value || '-'));
                        tbody.append(tr);
                    });
                } else {
                    // Tampilkan pesan jika tidak ada data
                    tbody.append($('<tr>')
                        .append($('<td colspan="2">').text('Tidak ada data yang tersedia'))
                    );
                }

                // Masukkan tabel ke dalam modal dan tampilkan
                table.append(tbody);
                modalBody.append(table);
                $('#modal-detail').modal('show');
            });

            $('#btn-sign').on('click', function () {
                var url = $(this).data('url');
                $('.form-group').hide();
                $('#form-approve').attr('action', url);
                $('#btn-submit').text('Tandatang');
                $('#btn-submit').removeClass().addClass('btn btn-success');
                $('#modal-action').modal('show');
            })

            $('#btn-approve').on('click', function () {
                var url = $(this).data('url');
                $('#form-approve').attr('action', url);
                $('#btn-submit').text('Approve');
                $('#btn-submit').removeClass().addClass('btn btn-success');
                $('#modal-action').modal('show');
            })

            $('#btn-reject').on('click', function () {
                var url = $(this).data('url');
                $('#form-approve').attr('action', url);
                $('#btn-submit').text('Reject');
                $('#btn-submit').removeClass().addClass('btn btn-danger');
                $('#modal-action').modal('show');
            })
        })
    </script>
@endpush
