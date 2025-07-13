@extends('layouts.main')
@section('title', 'Document Type')

@section('content')
    <section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Document Type</h1>
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
                            <div class="col-md-4">
                                <div class="row">
                                        <div class="mt-2">
                                            <a href="#" class="hidden" id="btn-destroy"><i class="fa fa-trash text-red"></i></a>
                                        </div>
                                </div>
                            </div>
                            <div class="col-md-8">

                                    <button class="btn btn-primary float-right" id="btn-create"><i class="nav-icon fa fa-plus"></i>  Tambah Document Type</button>

                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover" id="data-table" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>Deskripsi</th>
                                        <th>Fields</th>
                                        <th>Status</th>
                                        <th class="text-center" style="width: 10%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($document_types as $document_type)
                                    <tr>
                                        <td>{{ $document_type->name }}</td>
                                        <td>{{ $document_type->description ?? '-' }}</td>
                                        <td>{{ $document_type->formFields?->count() }}</td>
                                        <td>{{ $document_type->status ? 'Aktif' : 'Tidak Aktif' }}</td>
                                        <td class="text-center text-nowrap">

                                            <a href="{{ route('document.field.index', $document_type->id) }}" >
                                                <i class="fa fa-file mr-3 text-dark"></i>
                                            </a>
                                            <a href="#" class="edit" id="btn-edit" data-url="{{ route('document.type.update', $document_type->id) }}" data-id="{{ $document_type->id }}" data-get="{{ route('document.type.show', $document_type->id) }}">
                                                <i class="fa fa-pen mr-3 text-dark"></i>
                                            </a>

                                                <a href="#" id="btn-destroy" data-id="{{ $document_type->id }}" data-url="{{ route('document.type.destroy', $document_type->id) }}"><i class="fa fa-trash text-red"></i></a>

                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@include('back-end.document.type.create')
@include('back-end.document.type.edit')
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#btn-create').click(function() {
            $('#name').val('');
            $('#description').val('');
            $('#status').attr('checked', true);
            $('#modal-create').modal('show');
        });
        $('#data-table tbody').on('click', 'a#btn-destroy', function (e) {
            e.preventDefault(); // Mencegah aksi default dari link anchor
            var arrId = $(this).data('id');
            // Pastikan route 'user.destroy' didefinisikan untuk menerima parameter ID.
            // Ganti 'id' dengan nama parameter yang benar jika berbeda (misalnya 'user').
            var url = $(this).data('url');

            Swal.fire({
                title: "Apakah Anda yakin ingin menghapus data ini?",
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: "warning", // Menggunakan 'icon' bukan 'type' untuk SweetAlert2
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Ya, hapus!",
                cancelButtonText: "Batal",
                // closeOnConfirm: false, // Tidak diperlukan untuk SweetAlert2 modern dengan .then()
            }).then((result) => {
                if (result.isConfirmed){
                    $.ajax({
                        url: url, // Menggunakan URL yang sudah dikonstruksi dengan benar
                        type: "POST",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            // "id": arrId // Mungkin tidak diperlukan jika ID sudah ada di URL dan controller mengambil dari route parameter.
                                         // Jika controller Anda secara spesifik membutuhkan 'id' di body POST, biarkan ini.
                        },
                        success: function (response) {
                            // Server akan melakukan redirect dan menampilkan flash message.
                            // Cukup reload halaman untuk melihat perubahan dan pesan.
                            // Swal di sini bersifat opsional untuk feedback instan sebelum reload.
                            Swal.fire("Terhapus!", "Data berhasil dihapus.", "success").then(function(){
                                location.reload();
                            });
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            // Error pada request AJAX (misal server error 500, 403).
                            // Server mungkin juga sudah menyiapkan flash message error saat redirect.
                            // console.log(xhr.responseText);

                            Swal.fire("Gagal!", "Terjadi kesalahan saat menghapus data. Silakan coba lagi.", "error").then(function(){
                                location.reload();
                            });
                        }
                    });
                }
            });
        });

        $('#data-table tbody').on('click', '#btn-edit', function () {
            var id = $(this).data('id');
            var url = $(this).data('url');
            var url_hit = $(this).data('get');
            $.ajax({
                url: url_hit,
                type: 'GET',
            })
            .done(function (response) {
                if(response && response.status){ // Pastikan response dan response.status ada
                    $('#name_edit').val(response.data.name);
                    $('#description_edit').val(response.data.description);
                    $('#status_edit').prop('checked', response.data.status);
                    $("#form-edit").attr('action', url);
                    $('#modal-edit').modal('show');
                } else {
                    console.error("Gagal memuat data atau format respons tidak valid:", response);
                    Swal.fire("Gagal!", "Tidak dapat memuat data pengguna untuk diedit.", "error");
                }
            })
            .fail(function () {
                console.log("error");
            });
        });

    });
</script>
@endpush
